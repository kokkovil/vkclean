<?php

  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~vkokkone/vkclean/etusivu?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
  $request = str_replace('/~vkokkone/vkclean','',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

  require_once '../src/init.php';

  // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
  $templates = new League\Plates\Engine(TEMPLATE_DIR);

// Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava käsittelijä.
switch ($request) {
  case '/':
  case '/etusivu':
      echo $templates->render('etusivu');
      break;
  case '/palvelut':
      require_once MODEL_DIR . 'palvelu.php'; // Lisää tämä rivi
      $palvelut = haePalvelut(); // Lisää tämä rivi
      echo $templates->render('palvelut', ['palvelut' => $palvelut]); // Muuta tämä rivi
      break;
  case '/yhteystiedot':
      echo $templates->render('yhteystiedot');
      break;
  case '/hinnasto':
      echo $templates->render('hinnasto');
      break;
  case '/tietoa-yrityksesta':
      echo $templates->render('tietoa-yrityksesta');
      break;
  default:
      echo $templates->render('notfound');
      break;
}

?>




