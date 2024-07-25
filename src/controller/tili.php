<?php

function lisaaTili($formdata, $baseurl='') {

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
    } else {
        if (haeAsiakasSahkopostilla($formdata['email'])) {
          $error['email'] = "Sähköpostiosoite on jo käytössä.";
        }
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

        // Tarkistetaan onnistuiko henkilön tietojen lisääminen.
    // Jos idhenkilo-muuttujassa on positiivinen arvo,
    // onnistui rivin lisääminen. Muuten liäämisessä ilmeni
    // ongelma.
    if ($idasiakas) {

      // Luodaan käyttäjälle aktivointiavain ja muodostetaan
      // aktivointilinkki.
      require_once(HELPERS_DIR . "secret.php");
      $avain = generateActivationCode($email);
      $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/vahvista?key=$avain";

      // Päivitetään aktivointiavain tietokantaan ja lähetetään
      // käyttäjälle sähköpostia. Jos tämä onnistui, niin palautetaan
      // palautusarvona tieto tilin onnistuneesta luomisesta. Muuten
      // palautetaan virhekoodi, joka ilmoittaa, että jokin
      // lisäyksessä epäonnistui.
      if (paivitaVahvavain($email,$avain) && lahetaVahvavain($email,$url)) {
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

function lahetaVahvavain($email,$url) {
  $message = "Hei!\n\n" . 
             "Olet luonut tilin tällä shköpostiosoitteella,\n" . 
             "VKClean sivustolle. Klikkaamalla alla olevaa\n" . 
             "linkkiä vahvistat käyttämäsi sähköpostiosoitteen\n" .
             "ja pääset käyttämään Ota yhteyttä sivua.\n\n" . 
             "$url\n\n" .
             "Jos et ole rekisteröitynyt VKClean sivulle, niin\n" . 
             "silloin tämä sähköposti on tullut sinulle\n" .
             "vahingossa. Siinä tapauksessa ole hyvä ja\n" .
             "poista tämä viesti.\n\n".
             "Terveisin, VKCclean";
  return mail($email,'VKClean sivuston aktivointilinkki',$message);
}

function lahetaVaihtoavain($email,$url) {
  $message = "Hei!\n\n" .
             "Olet pyytänyt tilisi salasanan vaihtoa, klikkaamalla\n" .
             "alla olevaa linkkiä pääset vaihtamaan salasanasi.\n" .
             "Linkki on voimassa 30 minuuttia.\n\n" .
             "$url\n\n" .
             "Jos et ole pyytänyt tilisi salasanan vaihtoa, niin\n" .
             "voit poistaa tämän viestin turvallisesti.\n\n" .
             "Terveisin, VKClean";
  return mail($email,'VKClean-tilin salasanan vaihtaminen',$message);
}

function luoVaihtoavain($email, $baseurl='') {

  // Luodaan käyttäjälle vaihtoavain ja muodostetaan
  // vaihtolinkki.
  require_once(HELPERS_DIR . "secret.php");
  $avain = generateResetCode($email);
  $url = 'https://' . $_SERVER['HTTP_HOST'] . $baseurl . "/reset?key=$avain";

  // Tuodaan asiakas-mallin funktiot, joilla voidaan lisätä
  // vaihtoavaimen tiedot kantaan.
  require_once(MODEL_DIR . 'asiakas.php');

  // Lisätään vaihtoavain tietokantaan ja lähetetään
  // käyttäjälle sähköpostia. Jos tämä onnistui, niin palautetaan
  // palautusarvona vaihtoavain ja sähköpostiosoite. Muuten
  // palautetaan virhekoodi, joka ilmoittaa, että jokin lisäyksessä
  // epäonnistui.
  if (asetaVaihtoavain($email,$avain) && lahetaVaihtoavain($email,$url)) {
    return [
      "status"   => 200,
      "email"    => $email,
      "resetkey" => $avain
    ];
  } else {
    return [
      "status" => 500,
      "email"   => $email
    ];
  }

}

?>
