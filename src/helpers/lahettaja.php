<?php

function sendAdminEmails($formData, $adminEmails) {
    $subject = 'Uusi yhteydenotto verkkosivuiltasi'; // Muokkaa sähköpostin aihe
    $message = "Olet saanut uuden yhteydenoton verkkosivuiltasi:\n\n";
    
    // Kenttäotsikoiden määrittely
    $fieldNames = [
        'name' => 'Nimi',
        'email' => 'Sähköpostiosoite',
        'message' => 'Viesti',
        
    ];

    // Lisää lomakkeen tiedot viestiin
    foreach ($formData as $key => $value) {
        if (isset($fieldNames[$key])) { // Tarkistaa, onko kenttä määritelty
            $label = $fieldNames[$key];
            $message .= "$label: " . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . "\n";
    }
}

    // Tarkistaa, ettei viestin loppuun ole jäänyt ylimääräistä tekstiä tai merkkejä
    $message = trim($message); // Poistaa mahdolliset ylimääräiset rivinvaihdot tai välilyönnit viestin alusta ja lopusta

    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: " . htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8') . "\r\n"; // Lisää Reply-To
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion(); // Lisää X-Mailer

    foreach ($adminEmails as $email) {
        mail($email, $subject, $message, $headers);
    }
}
?>
