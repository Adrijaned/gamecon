<?php

/**
 * DrD, Trojboj, Gamecon, Placení aj.
 *
 * nazev: Shop
 * pravo: 100
 */


function zabalSoubor($cestaNaWebu)
{
  $verze = md5_file(WWW . '/' . $cestaNaWebu);
  $url = URL_WEBU . '/' . $cestaNaWebu . '?v=' . $verze;
  return $url;
}

if (!empty($_POST['prodej-mrizka'])) {
  $prodeje = $_POST['prodej-mrizka'];

  foreach ($prodeje as $prodej) {
    $prodej['id_uzivatele'] = $uPracovni ? $uPracovni->id() : 0;

    for ($kusu = $prodej['kusu'] ?? 1, $i = 1; $i <= $kusu; $i++) {
      dbQuery('INSERT INTO shop_nakupy(id_uzivatele,id_predmetu,rok,cena_nakupni,datum)
    VALUES (' . $prodej['id_uzivatele'] . ',' . $prodej['id_predmetu'] . ',' . ROK . ',(SELECT cena_aktualni FROM shop_predmety WHERE id_predmetu=' . $prodej['id_predmetu'] . '),NOW())');
    }
    $idPredmetu = (int)$prodej['id_predmetu'];
    $nazevPredmetu = dbOneCol(
      <<<SQL
      SELECT nazev FROM shop_predmety
      WHERE id_predmetu = $idPredmetu
      SQL
    );
  }

  oznameni("350 poprvé ... podruhé ... Prodáno !!");
  back();
}

?>

<!-- Náhrada za api call -->
<form id="prodej-mrizka-form" method="POST" style="display:none;"></form>

<link rel="stylesheet" href="<?= zabalSoubor('soubory/ui/style.css') ?>">

<div id="preact-obchod">Obchod se načítá ...</div>

<script>
  // Konstanty předáváné do Preactu (env.ts)
  window.GAMECON_KONSTANTY = {
    BASE_PATH_API: "<?= "/admin/api/" ?>",
    ROK: <?= ROK ?>,
  }
</script>

<script type="module" src="<?= zabalSoubor('soubory/ui/bundle.js') ?>"></script>