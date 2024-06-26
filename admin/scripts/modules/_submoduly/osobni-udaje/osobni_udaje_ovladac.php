<?php

/**
 * @var Uzivatel|null|void $u
 * @var Uzivatel|null|void $uPracovni
 * @var \Gamecon\Vyjimkovac\Vyjimkovac $vyjimkovac
 * @var \Gamecon\SystemoveNastaveni\SystemoveNastaveni $systemoveNastaveni
 */

if (post('zmenitUdaj') && $uPracovni) {
    $udaje = post('udaj');
    if ($udaje['op'] ?? null) {
        $uPracovni->cisloOp($udaje['op']);
        unset($udaje['op']);
    }
    if (isset($udaje['kontrola'])) {
        $uPracovni->nastavZkontrolovaneUdaje($u, (bool)$udaje['kontrola']);
        unset($udaje['kontrola']);
    }
    try {
        dbUpdate('uzivatele_hodnoty', $udaje, ['id_uzivatele' => $uPracovni->id()]);
    } catch (DbDuplicateEntryException $e) {
        if ($e->key() === 'email1_uzivatele') {
            chyba('Uživatel se stejným e-mailem již existuje.');
        } else if ($e->key() === 'login_uzivatele') {
            chyba('Uživatel se stejným e-mailem již existuje.');
        } else {
            chyba('Uživatel se stejným údajem již existuje.');
        }
    } catch (Exception $e) {
        $vyjimkovac->zaloguj($e);
        chyba('Došlo k neočekávané chybě.');
    }

    $uPracovni->otoc();

    if ($uPracovni->maZkontrolovaneUdaje()) {
        $maObjednaneUbytovani = $uPracovni->shop()->ubytovani()->maObjednaneUbytovani();
        $chybejiciUdaje       = $uPracovni->chybejiciUdaje(Uzivatel::povinneUdajeProRegistraci($maObjednaneUbytovani));
        if (count($chybejiciUdaje) > 0) {
            $uPracovni->nastavZkontrolovaneUdaje($u, false);
            $uPracovni->uloz();
            varovani('Uživatel nemá kompletní údaje. Potvrzení že měl údaje zkontrolované bylo zrušeno. Oprav údaje a zkontroluj je znovu.');
        }
    }

    back();
}
