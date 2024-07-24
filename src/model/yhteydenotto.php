<?php
function tallennaYhteydenotto($nimi, $email, $viesti) {
    global $pdo; // Oletetaan, että $pdo on PDO-yhteysobjekti

    $sql = "INSERT INTO yhteydenotot (nimi, email, viesti) VALUES (:nimi, :email, :viesti)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nimi', $nimi);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':viesti', $viesti);

    return $stmt->execute();
}
?>
