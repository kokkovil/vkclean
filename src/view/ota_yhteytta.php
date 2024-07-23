<?php $this->layout('template', ['title' => 'Ota Yhteyttä']) ?>

<h1>Ota Yhteyttä</h1>


<form action="<?= BASEURL ?>/otayhteytta" method="post">
    <div>
        <label for="name">Nimi:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars(getValue($formdata, 'name')) ?>" required>
        <div class="error"><?= htmlspecialchars(getValue($error, 'name')) ?></div>
    </div>

    <div>
        <label for="email">Sähköposti:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars(getValue($formdata, 'email')) ?>" required>
        <div class="error"><?= htmlspecialchars(getValue($error, 'email')) ?></div>
    </div>

    <div>
        <label for="message">Viesti:</label>
        <textarea id="message" name="message" rows="5" required><?= htmlspecialchars(getValue($formdata, 'message')) ?></textarea>
        <div class="error"><?= htmlspecialchars(getValue($error, 'message')) ?></div>
    </div>

    <div>
        <button type="submit" name="submit">Lähetä</button>
    </div>
</form>

