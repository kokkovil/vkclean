<?php

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
    default:
        echo $templates->render('notfound');
        break;
}
?>






