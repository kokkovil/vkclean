<?php $this->layout('template', ['title' => 'Ota Yhteyttä']) ?>

<h1>Ota Yhteyttä</h1>

<form action="<?= BASEURL ?>/otayhteytta" method="post" class="contact-form">
    <div class="form-group">
        <label for="name" class="form-label">Nimi:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars(getValue($formdata, 'name')) ?>" required class="form-input">
        <div class="error"><?= htmlspecialchars(getValue($error, 'name')) ?></div>
    </div>

    <div class="form-group">
        <label for="email" class="form-label">Sähköposti:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars(getValue($formdata, 'email')) ?>" required class="form-input">
        <div class="error"><?= htmlspecialchars(getValue($error, 'email')) ?></div>
    </div>

    <div class="form-group">
        <label for="message" class="form-label">Viesti:</label>
        <textarea id="message" name="message" rows="5" required class="form-textarea"><?= htmlspecialchars(getValue($formdata, 'message')) ?></textarea>
        <div class="error"><?= htmlspecialchars(getValue($error, 'message')) ?></div>
    </div>

    <div class="form-group">
        <button type="submit" name="submit" class="form-submit">Lähetä</button>
    </div>
</form>


