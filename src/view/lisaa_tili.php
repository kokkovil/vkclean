<?php $this->layout('template', ['title' => 'Uuden tilin luonti']) ?>

<h1>Uuden tilin luonti</h1>

<form action="" method="POST">
  <div>
    <label for="nimi">Nimi:</label>
    <input id="nimi" type="text" name="nimi" value="<?= htmlspecialchars(getValue($formdata, 'nimi')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error, 'nimi')); ?></div>
  </div>

  <div>
    <label for="yritys">Yritys:</label>
    <input id="yritys" type="text" name="yritys" value="<?= htmlspecialchars(getValue($formdata, 'yritys')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error, 'yritys')); ?></div>
  </div>

  <div>
    <label for="puhelinnumero">Puhelinnumero:</label>
    <input id="puhelinnumero" type="text" name="puhelinnumero" value="<?= htmlspecialchars(getValue($formdata, 'puhelinnumero')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error, 'puhelinnumero')); ?></div>
  </div>

  <div>
    <label for="email">Sähköposti:</label>
    <input id="email" type="text" name="email" value="<?= htmlspecialchars(getValue($formdata, 'email')) ?>">
    <div class="error"><?= htmlspecialchars(getValue($error, 'email')); ?></div>
  </div>

  <div>
    <label for="salasana1">Salasana:</label>
    <input id="salasana1" type="password" name="salasana1">
    <div class="error"><?= htmlspecialchars(getValue($error, 'salasana')); ?></div>
  </div>

  <div>
    <label for="salasana2">Salasana uudelleen:</label>
    <input id="salasana2" type="password" name="salasana2">
  </div>

  <div>
    <input type="submit" name="laheta" value="Luo tili">
  </div>
</form>

