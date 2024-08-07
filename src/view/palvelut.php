<?php $this->layout('template', ['title' => 'Palvelut']) ?>

<h1 style="text-align: center; font-size: 2.5rem;">Palvelumme</h1>

<div class='palvelut'>
<?php foreach ($palvelut as $palvelu_item): ?>
    <div class="palvelu-item">
        <!-- Testataan JavaScriptiä Linkki, joka kutsuu JavaScript-funktiota -->
        <div class="palvelu-link">
            <a href='javascript:void(0)' onclick='toggleService(<?= $palvelu_item["palvelu_id"] ?>)' style="font-size: 1.5rem;">
                <?= htmlspecialchars($palvelu_item['palvelu_nimi']) ?>
            </a>
        </div>
        
        <!-- Palvelun sisältö, joka näytetään/piilotetaan klikkauksen mukaan -->
        <div id="palvelu-content-<?= $palvelu_item['palvelu_id'] ?>" class="palvelu-content" style="display: <?= ($palvelu && $palvelu_item['palvelu_id'] == $palvelu['palvelu_id']) ? 'block' : 'none' ?>;">
            <h2 style="font-size: 1rem;"><?= htmlspecialchars($palvelu_item['palvelu_nimi']) ?></h2>
            <div style="font-size: 1rem;"><?= htmlspecialchars($palvelu_item['palvelu_kuvaus']) ?></div>
            <div style="font-size: 1rem;">Hinta: <?= htmlspecialchars($palvelu_item['palvelu_hinta']) ?> €</div>
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




