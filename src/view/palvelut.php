<?php $this->layout('template', ['title' => 'Palvelut']) ?>

<h1>Palvelumme</h1>

<div class='palvelut'>
<?php

foreach ($palvelut as $palvelu) {
    echo "<div>";
        echo "<h2>{$palvelu['name']}</h2>";
        echo "<p>{$palvelu['description']}</p>";
        echo "<p>Hinta: {$palvelu['price']} €</p>";
    echo "</div>";
}

?>
</div>
