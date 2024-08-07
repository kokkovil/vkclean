<?php $this->layout('template', ['title' => 'Palvelut']) ?>

<h1>Palvelumme</h1>

<div class='palvelut'>
<?php foreach ($palvelut as $palvelu_item): ?>
    <div class="palvelu-item">
        <!-- Testataan JavaScriptiä Linkki, joka kutsuu JavaScript-funktiota -->
        <div class="palvelu-link">
            <a href='javascript:void(0)' onclick='toggleService(<?= $palvelu_item["palvelu_id"] ?>)'>
                <?= htmlspecialchars($palvelu_item['palvelu_nimi']) ?>
            </a>
        </div>
        
        <!-- Palvelun sisältö, joka näytetään/piilotetaan klikkauksen mukaan -->
        <div id="palvelu-content-<?= $palvelu_item['palvelu_id'] ?>" class="palvelu-content" style="display: <?= ($palvelu && $palvelu_item['palvelu_id'] == $palvelu['palvelu_id']) ? 'block' : 'none' ?>;">
            <h2><?= htmlspecialchars($palvelu_item['palvelu_nimi']) ?></h2>
            <div><?= htmlspecialchars($palvelu_item['palvelu_kuvaus']) ?></div>
            <div>Hinta: <?= htmlspecialchars($palvelu_item['palvelu_hinta']) ?> €</div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<script>
function toggleService(id) {
    var content = document.getElementById('palvelu-content-' + id);
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
    } else {
        content.style.display = 'none';
    }
}
</script>



