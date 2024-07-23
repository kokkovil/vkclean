<?php

function lisaaTili($formdata) {
  
  // Tuodaan asiakas-mallin funktiot, joilla voidaan lisätä
  // asiakkaan tiedot tietokantaan.
  require_once MODEL_DIR . 'asiakas.php';

  // Alustetaan virhetaulukko, joka palautetaan lopuksi joko
  // tyhjänä tai virheillä täytettynä.
  $error = [];

  // Lomaketietojen puhdistus ja tarkistus

  // Tarkistetaan onko nimi määritelty ja se täyttää mallin.
  if (!isset($formdata['nimi']) || !$formdata['nimi']) {
    $error['nimi'] = "Anna nimesi.";
  } else {
    if (!preg_match("/^[- '\p{L}]+$/u", $formdata["nimi"])) {
      $error['nimi'] = "Syötä nimesi ilman erikoismerkkejä.";
    }
  }

  // Tarkistetaan ja puhdistetaan yritys
if (isset($formdata['yritys'])) {
    $formdata['yritys'] = trim($formdata['yritys']); // Poistaa ylimääräiset välilyönnit alusta ja lopusta
    if (!preg_match("/^[\p{L}0-9 .-]+$/u", $formdata['yritys'])) {
        $error['yritys'] = "Yrityksen nimi voi sisältää vain kirjaimia, numeroita, pisteitä, välilyöntejä ja viivoja.";
    }
}


  // Tarkistetaan ja puhdistetaan puhelinnumero
  if (isset($formdata['puhelinnumero'])) {
    $formdata['puhelinnumero'] = preg_replace('/\D/', '', $formdata['puhelinnumero']); // Poista ei-numeeriset merkit
    if (strlen($formdata['puhelinnumero']) < 5 || strlen($formdata['puhelinnumero']) > 15) {
      $error['puhelinnumero'] = "Puhelinnumeron tulee olla 5-15 numeromerkkiä pitkä.";
    }
  }

  // Tarkistetaan, että sähköpostiosoite on määritelty ja se on
  // oikeassa muodossa.
  if (!isset($formdata['email']) || !$formdata['email']) {
    $error['email'] = "Anna sähköpostiosoitteesi.";
  } else {
    if (!filter_var($formdata['email'], FILTER_VALIDATE_EMAIL)) {
      $error['email'] = "Sähköpostiosoite on virheellisessä muodossa.";
    }
  }

  // Tarkistetaan, että kummatkin salasanat on annettu ja että
  // ne ovat keskenään samat.
  if (isset($formdata['salasana1']) && $formdata['salasana1'] &&
      isset($formdata['salasana2']) && $formdata['salasana2']) {
    if ($formdata['salasana1'] != $formdata['salasana2']) {
      $error['salasana'] = "Salasanasi eivät olleet samat!";
    }
  } else {
    $error['salasana'] = "Syötä salasanasi kahteen kertaan.";
  }

  // Lisätään tiedot tietokantaan, jos edellä syötettyissä
  // tiedoissa ei ollut virheitä eli error-taulukosta ei
  // löydy virhetekstejä.
  if (!$error) {

    // Haetaan lomakkeen tiedot omiin muuttujiinsa.
    // Salataan salasana myös samalla.
    $nimi = $formdata['nimi'];
    $yritys = isset($formdata['yritys']) ? $formdata['yritys'] : null;
    $puhelinnumero = isset($formdata['puhelinnumero']) ? $formdata['puhelinnumero'] : null;
    $email = $formdata['email'];
    $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);

    // Lisätään asiakas tietokantaan. Jos lisäys onnistui,
    // tulee palautusarvona lisätyn asiakkaan id-tunniste.
    $idasiakas = lisaaAsiakas($nimi, $yritys, $puhelinnumero, $email, $salasana);

    // Tarkistetaan onnistuiko asiakkaan tietojen lisääminen.
    // Jos idasiakas-muuttujassa on positiivinen arvo,
    // onnistui rivin lisääminen. Muuten liäämisessä ilmeni
    // ongelma.
    if ($idasiakas) {
      return [
        "status" => 200,
        "id"     => $idasiakas,
        "data"   => $formdata
      ];
    } else {
      return [
        "status" => 500,
        "data"   => $formdata
      ];
    }

  } else {

    // Lomaketietojen tarkistuksessa ilmeni virheitä.
    return [
      "status" => 400,
      "data"   => $formdata,
      "error"  => $error
    ];

  }
}

?>
