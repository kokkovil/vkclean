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
    case '/yhteystiedot':
        echo $templates->render('yhteystiedot');
        break;
    case '/otayhteytta':
        echo $templates->render('otayhteytta');
        break;
    case '/tietoayrityksesta':
        echo $templates->render('tietoayrityksesta');
        break;
    default:
        echo $templates->render('notfound');
        break;
  }

?>




