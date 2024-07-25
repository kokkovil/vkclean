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

    case "/kirjaudu":
        if (isset($_POST['laheta'])) {
            require_once CONTROLLER_DIR . 'kirjaudu.php';
            if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
                require_once MODEL_DIR . 'asiakas.php';
                $user = haeAsiakas($_POST['email']);
                if ($user['vahvistettu']) {
                  session_regenerate_id();
                  $_SESSION['user'] = $user['email'];
                  header("Location: " . $config['urls']['baseUrl']);
                } else {
                  echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Tili on vahvistamatta! Ole hyvä, ja vahvista tili sähköpostissa olevalla linkillä.']]);
                }
              } else {
                echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
              }
            } else {
              echo $templates->render('kirjaudu', [ 'error' => []]);
            }
        break;
      
    case "/vahvista":
        if (isset($_GET['key'])) {
            $key = $_GET['key'];
            require_once MODEL_DIR . 'asiakas.php';
            if (vahvistaTili($key)) {
            echo $templates->render('tili_aktivoitu');
            } else {
            echo $templates->render('tili_aktivointi_virhe');
            }
        } else {
            header("Location: " . $config['urls']['baseUrl']);
        }
        break;

    case "/tilaa_vaihtoavain":
        $formdata = cleanArrayData($_POST);
        // Tarkistetaan, onko lomakkeelta lähetetty tietoa.
        if (isset($formdata['laheta'])) {    
        
            require_once MODEL_DIR . 'asiakas.php';
            // Tarkistetaan, onko lomakkeelle syötetty käyttäjätili olemassa.
            $user = haeAsiakas($formdata['email']);
            if ($user) {
              // Käyttäjätili on olemassa.
              // Luodaan salasanan vaihtolinkki ja lähetetään se sähköpostiin.
              require_once CONTROLLER_DIR . 'tili.php';
              $tulos = luoVaihtoavain($formdata['email'],$config['urls']['baseUrl']);
              if ($tulos['status'] == "200") {
                // Vaihtolinkki lähetty sähköpostiin, tulostetaan ilmoitus.
                echo $templates->render('tilaa_vaihtoavain_lahetetty');
                break;
              }
              // Vaihtolinkin lähetyksessä tapahtui virhe, tulostetaan
              // yleinen virheilmoitus.
              echo $templates->render('virhe');
              break;
            } else {
              // Tunnusta ei ollut, tulostetaan ympäripyöreä ilmoitus.
              echo $templates->render('tilaa_vaihtoavain_lahetetty');
              break;
            }
    
        } else {
            // Lomakeelta ei ole lähetetty tietoa, tulostetaan lomake.
            echo $templates->render('tilaa_vaihtoavain_lomake');
        }
        break;
    case "/reset":
        // Otetaan vaihtoavain talteen.
        $resetkey = $_GET['key'];
      
        // Seuraavat tarkistukset tarkistavat, että onko vaihtoavain
        // olemassa ja se on vielä aktiivinen. Jos ei, niin tulostetaan
        // käyttäjälle virheilmoitus ja poistutaan.
        require_once MODEL_DIR . 'asiakas.php';
        $rivi = tarkistaVaihtoavain($resetkey);
        if ($rivi) {
            // Vaihtoavain löytyi, tarkistetaan onko se vanhentunut.
            if ($rivi['aikaikkuna'] < 0) {
                echo $templates->render('reset_virhe');
                break;
              }
            } else {
              echo $templates->render('reset_virhe');
              break;
            }
      
            // Vaihtoavain on voimassa, tarkistetaan onko lomakkeen kautta
            // syötetty tietoa.
            $formdata = cleanArrayData($_POST);
            if (isset($formdata['laheta'])) {
      
        // Lomakkeelle on syötetty uudet salasanat, annetaan syötteen
        // käsittely kontrollerille.
        require_once CONTROLLER_DIR . 'tili.php';
        $tulos = resetoiSalasana($formdata,$resetkey);
        // Tarkistetaan kontrollerin tekemän salasanaresetoinnin lopputulos.
        if ($tulos['status'] == "200") {
          // Salasana vaihdettu, tulostetaan ilmoitus.
          echo $templates->render('reset_valmis');
          break;
        }
        // Salasanan vaihto ei onnistunut, tulostetaan lomake virhetekstin kanssa.
        echo $templates->render('reset_lomake', ['error' => $tulos['error']]);
        break;

      
            } else {
              // Lomakkeen tietoja ei ole vielä täytetty, tulostetaan lomake.
              echo $templates->render('reset_lomake', ['error' => '']);
              break;
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








