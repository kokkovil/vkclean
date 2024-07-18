<?php

  // Siistitään polku urlin alusta ja mahdolliset parametrit urlin lopusta.
  // Oletetaan, että sovellus sijaitsee polussa /~vkokkone/vkclean.
  $request = str_replace('/~vkokkone/vkclean', '', $_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');

  // Selvitetään mitä sivua on kutsuttu ja suoritetaan sivua vastaava käsittelijä.
  if ($request === '/' || $request === '/etusivu') {
    echo '<h1>Tervetuloa VKCleanin kotisivuille</h1>';
  } else if ($request === '/palvelut') {
    echo '<h1>Palvelumme</h1>';
  } else if ($request === '/yhteystiedot') {
    echo '<h1>Yhteystiedot</h1>';
  } else if ($request === '/hinnasto') {
    echo '<h1>Hinnasto</h1>';
  } else if ($request === '/tietoa-yrityksesta') {
    echo '<h1>Tietoa yrityksestä</h1>';
  } else {
    echo '<h1>Pyydettyä sivua ei löytynyt</h1>';
  }

?>
