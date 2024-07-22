<?php $this->layout('template', ['title' => 'Palvelut']) ?>

<h1>Palvelumme</h1>

<div class='palvelut'>
<?php

foreach ($palvelut as $palvelu) {
    echo "<div>";
        echo "<h2><a href='/palvelu?id={$palvelu['palvelu_id']}'>{$palvelu['palvelu_nimi']}</a></h2>"; // Palvelun nimi on linkki
    echo "</div>";
}

?>
</div>


