<!DOCTYPE html>
<html lang="fi">
  <head>
    <link href="styles/styles.css" rel="stylesheet">
    <title>vkclean - <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
  </head>
  <body>
  <header>
      <h1><a href="<?=BASEURL?>">VKClean</a></h1>
      <nav>
        <ul>
          <li><a href="<?=BASEURL?>">Etusivu</a></li>
          <li><a href="<?=BASEURL?>palvelut.php">Palvelut</a></li>
          <li><a href="<?=BASEURL?>tietoayrityksesta">Tietoa Yrityksestä</a></li>
          <li><a href="<?=BASEURL?>yhteystiedot">Yhteystiedot</a></li>
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
