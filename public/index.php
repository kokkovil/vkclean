<?php

  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Siistimisen jälkeen osoite /~koodaaja/lanify/tapahtuma?id=1 on 
  // lyhentynyt muotoon /tapahtuma.
  $request = str_replace('/~vkokkone/vkclean','',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

  require_once '../src/init.php';

  // Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
  $templates = new League\Plates\Engine(TEMPLATE_DIR);

// Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava
// käsittelijä.
if ($request === '/' || $request === '/etusivu') {
  echo $templates->render('etusivu');
} else if ($request === '/palvelut') {
  echo $templates->render('palvelut');
} else if ($request === '/yhteystiedot') {
  echo $templates->render('yhteystiedot');
} else if ($request === '/hinnasto') {
  echo $templates->render('hinnasto');
} else if ($request === '/tietoa-yrityksesta') {
  echo $templates->render('tietoa-yrityksesta');
} else {
  echo $templates->render('notfound');
}

?> 




