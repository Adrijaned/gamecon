<?php

if (post('zmenitUdaj') && $uPracovni) {
    $udaje = post('udaj');
    if ($udaje['op'] ?? null) {
        $uPracovni->cisloOp($udaje['op']);
        unset($udaje['op']);
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
    back();
}