<?php

require_once '../src/init.php';

// Luodaan uusi Plates-olio ja kytketään se sovelluksen sivupohjiin.
$templates = new League\Plates\Engine('../src/view');

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



