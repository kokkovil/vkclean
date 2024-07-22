<?php

require_once HELPERS_DIR . 'DB.php';

function haePalvelut() {
    return DB::run('SELECT * FROM palvelut ORDER BY name;')->fetchAll();
}

?>
