<?php $this->layout('template', ['title' => 'Palvelut']) ?>

<h1>Palvelumme</h1>

<div class='palvelut'>
<?php

foreach ($palvelut as $palvelu) {
    // Luo linkin, jossa palvelu_nimi on linkin teksti ja palvelu_id on linkin kohde
    echo "<div>";
    echo "<div><a href='palvelu?id=" . $palvelu['palvelu_id'] . "'>" . htmlspecialchars($palvelu['palvelu_nimi']) . "</a></div>";
    echo "</div>";

}

?>
</div>


