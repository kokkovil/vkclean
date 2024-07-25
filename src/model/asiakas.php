<?php

require_once HELPERS_DIR . 'DB.php';

function lisaaAsiakas($nimi, $yritys, $puhelinnumero, $email, $salasana) {
    // Korjattu SQL-lause ja lisätty puuttuva sulku
    $sql = 'INSERT INTO asiakas (nimi, yritys, puhelinnumero, email, salasana) VALUES (?, ?, ?, ?, ?)';
    DB::run($sql, [$nimi, $yritys, $puhelinnumero, $email, $salasana]);
    return DB::lastInsertId();
}

function haeAsiakasSahkopostilla($email) {
    return DB::run('SELECT * FROM asiakas WHERE email = ?;', [$email])->fetchAll();
}

function haeAsiakas($email) {
    return DB::run('SELECT * FROM asiakas WHERE email = ?;', [$email])->fetch();
}

function paivitaVahvavain($email,$avain) {
    return DB::run('UPDATE asiakas SET vahvavain = ? WHERE email = ?', [$avain,$email])->rowCount();
  }

  function vahvistaTili($avain) {
    return DB::run('UPDATE asiakas SET vahvistettu = TRUE WHERE vahvavain = ?', [$avain])->rowCount();
  }
?>
