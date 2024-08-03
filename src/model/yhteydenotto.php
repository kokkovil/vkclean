<?php

require_once HELPERS_DIR . 'DB.php';

/**
 * Lisää uuden yhteydenoton tietokantaan.
 *
 * @param string $nimi Yhteydenoton lähettäjän nimi.
 * @param string $email Yhteydenoton lähettäjän sähköpostiosoite.
 * @param string $viesti Yhteydenoton viesti.
 * @return int Lisätyn yhteydenoton ID.
 */
function lisaaYhteydenotto($nimi, $email, $viesti) {
    $sql = 'INSERT INTO yhteydenotot (nimi, email, viesti, luotu) VALUES (?, ?, ?, NOW())';
    DB::run($sql, [$nimi, $email, $viesti]);
    return DB::lastInsertId();
}

/**
 * Hakee yhteydenoton ID:n perusteella.
 *
 * @param int $id Yhteydenoton ID.
 * @return array Yhteydenoton tiedot.
 */
function haeYhteydenotto($id) {
    return DB::run('SELECT * FROM yhteydenotot WHERE id = ?;', [$id])->fetch();
}

?>


