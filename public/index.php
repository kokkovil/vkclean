<?php

session_start();

// Suoritetaan projektin alustusskripti.
require_once '../src/init.php';

// Haetaan kirjautuneen käyttäjän tiedot.
if (isset($_SESSION['user'])) {
    require_once MODEL_DIR . 'asiakas.php';
    $loggeduser = haeAsiakas($_SESSION['user']);
} else {
    $loggeduser = NULL;
}

$request = str_replace('/~vkokkone/vkclean', '', $_SERVER['REQUEST_URI']);
$request = strtok($request, '?');

$templates = new League\Plates\Engine(TEMPLATE_DIR);

switch ($request) {
    case '/':
    case '/etusivu':
        echo $templates->render('etusivu');
        break;

    case '/palvelut':
        require_once MODEL_DIR . 'palvelu.php';
        $palvelut = haePalvelut();
        echo $templates->render('palvelut', ['palvelut' => $palvelut]);
        break;

    case '/palvelu':
        require_once MODEL_DIR . 'palvelu.php';
        if (isset($_GET['id'])) {
            $palvelu = haePalvelu($_GET['id']);
            if ($palvelu) {
                echo $templates->render('palvelu', ['palvelu' => $palvelu]);
            } else {
                echo $templates->render('palvelunotfound');
            }
        }
        break;

    case '/lisaa_tili':
        if (isset($_POST['laheta'])) {
            $formdata = cleanArrayData($_POST);
            require_once CONTROLLER_DIR . 'tili.php';
            $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
            if ($tulos['status'] == "200") {
                echo $templates->render('tili_luotu', ['formdata' => $formdata]);
            } else {
                echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
            }
        } else {
            echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        }
        break;

    case '/yhteystiedot':
        echo $templates->render('yhteystiedot');
        break;

    case '/ota_yhteytta':
        if ($loggeduser) {
            if (isset($_POST['laheta'])) {
                require_once CONTROLLER_DIR . 'ota_yhteytta.php';
                $tulos = otaYhteytta();

                if ($tulos['status'] == 200) {
                    echo $templates->render('kiitos'); // Ohjaa käyttäjä kiitos-sivulle
                } else {
                    echo $templates->render('ota_yhteytta', ['formdata' => $_POST, 'error' => $tulos['error']]);
                }
            } else {
                echo $templates->render('ota_yhteytta', ['formdata' => [], 'error' => []]);
            }
        } else {
            echo $templates->render('info'); // Ohjaa kirjautumattomat käyttäjät info-sivulle
        }
        break;

    case '/tietoayrityksesta':
        echo $templates->render('tietoayrityksesta');
        break;

    case '/kirjaudu':
        if (isset($_POST['laheta'])) {
            require_once CONTROLLER_DIR . 'kirjaudu.php';
            if (tarkistaKirjautuminen($_POST['email'], $_POST['salasana'])) {
                session_regenerate_id();
                $_SESSION['user'] = $_POST['email'];
                header("Location: " . BASEURL);
                exit();
            } else {
                echo $templates->render('kirjaudu', ['error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
            }
        } else {
            echo $templates->render('kirjaudu', ['error' => []]);
        }
        break;
    case "/vahvista":
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            require_once MODEL_DIR . 'henkilo.php';
            if (vahvistaTili($key)) {
            echo $templates->render('tili_aktivoitu');
            } else {
            echo $templates->render('tili_aktivointi_virhe');
            }
        } else {
            header("Location: " . $config['urls']['baseUrl']);
        }
        break;
      

    case '/logout':
        require_once CONTROLLER_DIR . 'kirjaudu.php';
        logout();
        header("Location: " . BASEURL);
        exit();

        

    default:
        echo $templates->render('notfound');
        break;
}
?>








