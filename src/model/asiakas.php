<?php

require_once HELPERS_DIR . 'DB.php';

function lisaaAsiakas($nimi, $yritys, $puhelinnumero, $email, $salasana) {
    
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
function asetaVaihtoavain($email,$avain) {
    return DB::run('UPDATE asiakas SET nollausavain = ?, nollausaika = NOW() + INTERVAL 30 MINUTE WHERE email = ?', [$avain,$email])->rowCount();
}

function tarkistaVaihtoavain($avain) {
    return DB::run('SELECT nollausavain, nollausaika-NOW() AS aikaikkuna FROM asiakas WHERE nollausavain = ?', [$avain])->fetch();
}

function vaihdaSalasanaAvaimella($salasana,$avain) {
    return DB::run('UPDATE asiakas SET salasana = ?, nollausavain = NULL, nollausaika = NULL WHERE nollausavain = ?', [$salasana,$avain])->rowCount();
}

?>
