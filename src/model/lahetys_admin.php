<?php

require_once HELPERS_DIR . 'DB.php';

/**
 * Hakee kaikkien adminien sähköpostiosoitteet.
 *
 * @return array Taulukko adminien sähköpostiosoitteista.
 */
function haeAdminEmails() {
    return DB::run('SELECT email FROM asiakas WHERE admin = 1;')->fetchAll(PDO::FETCH_COLUMN);
}

/**
 * Hakee yhteydenotot tietokannasta.
 *
 * @return array Taulukko yhteydenotoista.
 */
function haeYhteydenotot() {
    return DB::run('SELECT * FROM yhteydenotot ORDER BY luotu DESC;')->fetchAll();
}

/**
 * Poistaa yhteydenoton ID:n perusteella.
 *
 * @param int $id Yhteydenoton ID.
 * @return int Vaikutus rivien määrä (0 tai 1).
 */
function poistaYhteydenotto($id) {
    return DB::run('DELETE FROM yhteydenotot WHERE id = ?;', [$id])->rowCount();
}

?>
