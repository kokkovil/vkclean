<!DOCTYPE html>
<html lang="fi">
  <head>
    <link href="styles/styles.css" rel="stylesheet">
    <title>vkclean - <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
  </head>
  <body>
  <header>
  <div class="profile">
        <?php
          if (isset($_SESSION['user'])) {
            echo "<div>$_SESSION[user]</div>";
            echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
          } else {
            echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
          }
        ?>
      </div>
      <h1><a href="<?=BASEURL?>">VKClean</a></h1>
      <nav class="navigointi">
        <ul>
          <li><a href="<?= BASEURL ?>">Etusivu</a></li>
          <li><a href="<?= BASEURL ?>/palvelut">Palvelut</a></li>
          <li><a href="<?= BASEURL ?>/tietoayrityksesta">Tietoa Yrityksestä</a></li>
          <li><a href="<?= BASEURL ?>/yhteystiedot">Yhteystiedot</a></li>
          <li><a href="<?= BASEURL ?>/ota_yhteytta">Ota Yhteyttä</a></li>
        </ul>
      </nav>
    </header>
    <section>
      <?=$this->section('content')?>
    </section>
    <footer>
      <hr>
      <div>vkclean by Veera Kankaanpää</div>
    </footer>
  </body>
</html>
