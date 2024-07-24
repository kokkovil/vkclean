<?php
require_once MODEL_DIR . 'yhteydenotto.php'; // Tuodaan malli yhteydenotoille
require_once HELPERS_DIR . 'form.php'; // Lomake-tietojen käsittelyyn

function otaYhteytta() {
    $formdata = cleanArrayData($_POST);
    $error = [];

    // Tarkistetaan lomaketiedot
    if (!isset($formdata['name']) || !$formdata['name']) {
        $error['name'] = "Anna nimesi.";
    }

    if (!isset($formdata['email']) || !$formdata['email']) {
        $error['email'] = "Anna sähköpostiosoitteesi.";
    } else {
        if (!filter_var($formdata['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email'] = "Sähköpostiosoite on virheellisessä muodossa.";
        }
    }

    if (!isset($formdata['message']) || !$formdata['message']) {
        $error['message'] = "Kirjoita viestisi.";
    }

    // Jos ei virheitä, tallennetaan tiedot tietokantaan
    if (!$error) {
        $nimi = $formdata['name'];
        $email = $formdata['email'];
        $viesti = $formdata['message'];

        $result = tallennaYhteydenotto($nimi, $email, $viesti);

        if ($result) {
            return [
                "status" => 200,
                "message" => "Viesti lähetetty onnistuneesti."
            ];
        } else {
            return [
                "status" => 500,
                "message" => "Viestin lähettämisessä tapahtui virhe."
            ];
        }
    } else {
        return [
            "status" => 400,
            "error" => $error
        ];
    }
}
?>



