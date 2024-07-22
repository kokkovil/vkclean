<?php

require_once HELPERS_DIR . 'DB.php';

function haePalvelut() {
    return DB::run('SELECT * FROM palvelut ORDER BY palvelu_id;')->fetchAll();
}

function haePalvelu($id) {
    return DB::run('SELECT * FROM palvelut WHERE palvelu_id = ?;', [$id])->fetch();
}

?>


