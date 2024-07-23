<?php

function cleanArrayData($array = []) {
    $result = [];
    foreach ($array as $key => $value) {
        $cleaned = trim($value);
        $cleaned = stripslashes($cleaned);
        $result[$key] = $cleaned;
    }
    return $result;
}

function getValue($values, $key) {
    // Varmistetaan, että $values on taulukko
    if (is_array($values) && array_key_exists($key, $values)) {
        return htmlspecialchars($values[$key], ENT_QUOTES, 'UTF-8');
    } else {
        return ''; // Palauta tyhjää, jos avainta ei löydy tai $values ei ole taulukko
    }
}

?>

