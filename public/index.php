<?php
// Aloitetaan istunnot.
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

require_once '../src/init.php';

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

            // Kutsuu lisaaTili-funktiota lomaketiedoilla
            $tulos = lisaaTili($formdata);

            if ($tulos['status'] == "200") {
                echo $templates->render('tili_luotu', ['formdata' => $formdata]);
                break;
              
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
        echo $templates->render('ota_yhteytta');
        break;
    case '/tietoayrityksesta':
        echo $templates->render('tietoayrityksesta');
        break;
        case "/kirjaudu":
            if (isset($_POST['laheta'])) {
              require_once CONTROLLER_DIR . 'kirjaudu.php';
              if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
                session_regenerate_id();
                $_SESSION['user'] = $_POST['email'];
                header("Location: " . $config['urls']['baseUrl']);
              } else {
                echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
              }
            } else {
              echo $templates->render('kirjaudu', [ 'error' => []]);
            }
            break;
            case "/logout":
                require_once CONTROLLER_DIR . 'kirjaudu.php';
                logout();
                header("Location: " . $config['urls']['baseUrl']);
                break;
          
    default:
        echo $templates->render('notfound');
        break;
}
?>






