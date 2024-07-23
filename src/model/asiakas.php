<?php

require_once HELPERS_DIR . 'DB.php';

function lisaaAsiakas($nimi, $yritys, $puhelinnumero, $email, $salasana) {
    // Korjattu SQL-lause ja lisätty puuttuva sulku
    $sql = 'INSERT INTO asiakas (nimi, yritys, puhelinnumero, email, salasana) VALUES (?, ?, ?, ?, ?)';
    DB::run($sql, [$nimi, $yritys, $puhelinnumero, $email, $salasana]);
    return DB::lastInsertId();
}

?>
