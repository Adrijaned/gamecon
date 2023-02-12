<?php declare(strict_types=1);

namespace Gamecon\Role;

/**
 * @method static Role zId($id)
 */
class Role extends \DbObject
{

    protected static $tabulka = RoleSqlStruktura::ROLE_TABULKA;
    protected static $pk = RoleSqlStruktura::ID_ROLE;

    /**
     * Konstanty jsou kopie SQL tabulky `role_seznam`
     */
    // TRVALÉ ROLE
    public const ORGANIZATOR            = ROLE_ORGANIZATOR; // Organizátor (zdarma), Člen organizačního týmu GC
    public const ORGANIZATOR_S_BONUSY_1 = ROLE_ORGANIZATOR_S_BONUSY_1;
    public const ORGANIZATOR_S_BONUSY_2 = ROLE_ORGANIZATOR_S_BONUSY_2;
    public const CESTNY_ORGANIZATOR     = ROLE_CESTNY_ORGANIZATOR; // Bývalý organizátor GC
    public const SPRAVCE_FINANCI_GC     = ROLE_SPRAVCE_FINANCI_GC; // Organizátor, který může nakládat s financemi GC
    public const ADMIN                  = ROLE_ADMIN; // Spec. role pro úpravy databáze. NEPOUŽÍVAT.
    public const VYPRAVECSKA_SKUPINA    = ROLE_VYPRAVECSKA_SKUPINA; // Organizátorská skupina pořádající na GC (dodavatelé, …)

    // DOČASNÉ ROČNÍKOVÉ ROLE
    public const LETOSNI_VYPRAVEC             = ROLE_VYPRAVEC; // Organizátor aktivit na GC
    public const LETOSNI_ZAZEMI               = ROLE_ZAZEMI; // Členové zázemí GC (kuchařky, …)
    public const LETOSNI_INFOPULT             = ROLE_INFOPULT; // Operátor infopultu
    public const LETOSNI_PARTNER              = ROLE_PARTNER; // Vystavovatelé, lidé od deskovek, atp.
    public const LETOSNI_DOBROVOLNIK_SENIOR   = ROLE_DOBROVOLNIK_SENIOR; // Dobrovolník dlouhodobě spolupracující s GC
    public const LETOSNI_STREDECNI_NOC_ZDARMA = ROLE_STREDECNI_NOC_ZDARMA;
    public const LETOSNI_NEDELNI_NOC_ZDARMA   = ROLE_NEDELNI_NOC_ZDARMA;
    public const LETOSNI_NEODHLASOVAT         = ROLE_NEODHLASOVAT;
    public const LETOSNI_HERMAN               = ROLE_HERMAN;
    public const LETOSNI_BRIGADNIK            = ROLE_BRIGADNIK;

    protected const ROLE_VYPRAVEC_ID_ZAKLAD             = 6;
    protected const ROLE_ZAZEMI_ID_ZAKLAD               = 7;
    protected const ROLE_INFOPULT_ID_ZAKLAD             = 8;
    protected const ROLE_PARTNER_ID_ZAKLAD              = 13;
    protected const ROLE_DOBROVOLNIK_SENIOR_ID_ZAKLAD   = 17;
    protected const ROLE_STREDECNI_NOC_ZDARMA_ID_ZAKLAD = 18;
    protected const ROLE_NEDELNI_NOC_ZDARMA_ID_ZAKLAD   = 19;
    protected const ROLE_NEODHLASOVAT_ID_ZAKLAD         = 23;
    protected const ROLE_HERMAN_ID_ZAKLAD               = 24;
    protected const ROLE_BRIGADNIK_ID_ZAKLAD            = 25;

    // ROLE ÚČASTI
    public const PRIHLASEN_NA_LETOSNI_GC = ROLE_PRIHLASEN;
    public const PRITOMEN_NA_LETOSNIM_GC = ROLE_PRITOMEN;
    public const ODJEL_Z_LETOSNIHO_GC    = ROLE_ODJEL;

    protected const ROLE_PRIHLASEN_ID_ZAKLAD = 1;
    protected const ROLE_PRITOMEN_ID_ZAKLAD  = 2;
    protected const ROLE_ODJEL_ID_ZAKLAD     = 3;

    public const UDALOST_PRIHLASEN = 'přihlášen';
    public const UDALOST_PRITOMEN  = 'přítomen';
    public const UDALOST_ODJEL     = 'odjel';

    public const JAKYKOLI_ROCNIK            = -1;
    public const KOEFICIENT_ROCNIKOVE_ROLE = -100000;

    public const TYP_ROCNIKOVA = 'rocnikova';
    public const TYP_UCAST     = 'ucast';
    public const TYP_TRVALA    = 'trvala';

    // TYP TRVALE
    public const VYZNAM_ORGANIZATOR_ZDARMA     = 'ORGANIZATOR_ZDARMA';
    public const VYZNAM_ORGANIZATOR_S_BONUSY_1 = 'ORGANIZATOR_S_BONUSY_1';
    public const VYZNAM_ORGANIZATOR_S_BONUSY_2 = 'ORGANIZATOR_S_BONUSY_2';
    public const VYZNAM_CESTNY_ORGANIZATOR     = 'CESTNY_ORGANIZATOR';
    public const VYZNAM_SPRAVCE_FINANCI_GC     = 'SPRAVCE_FINANCI_GC';
    public const VYZNAM_ADMIN                  = 'ADMIN';
    public const VYZNAM_VYPRAVECSKA_SKUPINA    = 'VYPRAVECSKA_SKUPINA';
    // TYP ROCNIKOVE
    public const VYZNAM_BRIGADNIK            = 'BRIGADNIK';
    public const VYZNAM_DOBROVOLNIK_SENIOR   = 'DOBROVOLNIK_SENIOR';
    public const VYZNAM_HERMAN               = 'HERMAN';
    public const VYZNAM_INFOPULT             = 'INFOPULT';
    public const VYZNAM_NEDELNI_NOC_ZDARMA   = 'NEDELNI_NOC_ZDARMA';
    public const VYZNAM_NEODHLASOVAT         = 'NEODHLASOVAT';
    public const VYZNAM_PARTNER              = 'PARTNER';
    public const VYZNAM_STREDECNI_NOC_ZDARMA = 'STREDECNI_NOC_ZDARMA';
    public const VYZNAM_VYPRAVEC             = 'VYPRAVEC';
    public const VYZNAM_ZAZEMI               = 'ZAZEMI';
    // TYP UCAST
    public const VYZNAM_PRIHLASEN = 'PRIHLASEN';
    public const VYZNAM_PRITOMEN  = 'PRITOMEN';
    public const VYZNAM_ODJEL     = 'ODJEL';

    /**
     * @return int[]
     */
    public static function idckaTrvalychRoli(): array {
        return [
            Role::ORGANIZATOR,
            Role::ORGANIZATOR_S_BONUSY_1,
            Role::ORGANIZATOR_S_BONUSY_2,
            Role::CESTNY_ORGANIZATOR,
            Role::SPRAVCE_FINANCI_GC,
            Role::ADMIN,
            Role::VYPRAVECSKA_SKUPINA,
        ];
    }

    public static function vyznamPodleKodu(string $kodRole): string {
        return preg_replace('~^GC\d+_~', '', $kodRole);
    }

    /**
     * Přihlásil se, neboli registroval, na GameCon
     * @param int $rok
     * @return int
     */
    public static function PRIHLASEN_NA_LETOSNI_GC(int $rok = ROCNIK): int {
        return self::preProUcastRoku($rok) - self::ROLE_PRIHLASEN_ID_ZAKLAD;
    }

    /**
     * Prošel infopultem a byl na GameConu
     * @param int $rok
     * @return int
     */
    public static function PRITOMEN_NA_LETOSNIM_GC(int $rok = ROCNIK): int {
        return self::preProUcastRoku($rok) - self::ROLE_PRITOMEN_ID_ZAKLAD;
    }

    /**
     * Prošel infopultem na odchodu a odjel z GameConu
     * @param int $rok
     * @return int
     */
    public static function ODJEL_Z_LETOSNIHO_GC(int $rok = ROCNIK): int {
        return self::preProUcastRoku($rok) - self::ROLE_ODJEL_ID_ZAKLAD;
    }

    private static function preProUcastRoku(int $rok): int {
        return -($rok - 2000) * 100; // předpona pro role a práva vázaná na daný rok
    }

    public static function LETOSNI_VYPRAVEC(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_VYPRAVEC_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_ZAZEMI(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_ZAZEMI_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_INFOPULT(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_INFOPULT_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_PARTNER(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_PARTNER_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_DOBROVOLNIK_SENIOR(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_DOBROVOLNIK_SENIOR_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_STREDECNI_NOC_ZDARMA(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_STREDECNI_NOC_ZDARMA_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_NEDELNI_NOC_ZDARMA(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_NEDELNI_NOC_ZDARMA_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_NEODHLASOVAT(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_NEODHLASOVAT_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_HERMAN(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_HERMAN_ID_ZAKLAD, $rok);
    }

    public static function LETOSNI_BRIGADNIK(int $rok = ROCNIK): int {
        return self::idRocnikoveRole(self::ROLE_BRIGADNIK_ID_ZAKLAD, $rok);
    }

    public static function idRocnikoveRole(int $zakladIdRole, int $rok) {
        // 6, 2023 = -2 023 006
        return self::preProRocnikovouRoli($rok) - $zakladIdRole;
    }

    private static function preProRocnikovouRoli(int $rok): int {
        return $rok * self::KOEFICIENT_ROCNIKOVE_ROLE; // 2023 = 202 300 000
    }

    /**
     * @param int[] $idsRoli
     * @return bool
     */
    public static function obsahujiOrganizatora(array $idsRoli): bool {
        $idsRoliInt = array_map(static function ($idRole) {
            return (int)$idRole;
        }, $idsRoli);
        $maRole = array_intersect($idsRoliInt, self::dejIdckaRoliSOrganizatory());
        return count($maRole) > 0;
    }

    /**
     * @return int[]
     */
    public static function dejIdckaRoliSOrganizatory(): array {
        return [self::ORGANIZATOR, self::ORGANIZATOR_S_BONUSY_1, self::ORGANIZATOR_S_BONUSY_2];
    }

    public static function nazevRole(int $idRole): string {
        return match ($idRole) {
            self::ORGANIZATOR => 'Organizátor (zdarma)',
            self::LETOSNI_VYPRAVEC => 'Vypravěč',
            self::LETOSNI_ZAZEMI => 'Zázemí',
            self::LETOSNI_INFOPULT => 'Infopult',
            self::VYPRAVECSKA_SKUPINA => 'Vypravěčská skupina',
            self::LETOSNI_PARTNER => 'Partner',
            self::CESTNY_ORGANIZATOR => 'Čestný organizátor',
            self::ADMIN => 'Admin',
            self::LETOSNI_DOBROVOLNIK_SENIOR => 'Dobrovolník senior',
            self::LETOSNI_STREDECNI_NOC_ZDARMA => 'Středeční noc zdarma',
            self::LETOSNI_NEDELNI_NOC_ZDARMA => 'Nedělní noc zdarma',
            self::SPRAVCE_FINANCI_GC => 'Správce financí GC',
            self::ORGANIZATOR_S_BONUSY_1 => 'Organizátor (s bonusy 1)',
            self::ORGANIZATOR_S_BONUSY_2 => 'Organizátor (s bonusy 2)',
            self::LETOSNI_NEODHLASOVAT => 'Neodhlašovat',
            self::LETOSNI_HERMAN => 'Herman',
            self::LETOSNI_BRIGADNIK => 'Brigádník',
            default => self::nazevRoleStareUcasti($idRole),
        };
    }

    private static function nazevRoleStareUcasti(int $idRole): string {
        $rok     = self::rokDleRoleUcasti($idRole);
        $udalost = self::udalostDleRole($idRole);
        return "GC{$rok} {$udalost}";
    }

    public static function rokDleRoleUcasti(int $idRoleUcastiNagGc): int {
        if (self::jeToUcastNaGc($idRoleUcastiNagGc)) {
            return (int)(abs($idRoleUcastiNagGc) / 100) + 2000;
        }
        throw new \LogicException("Role (židle) s ID $idRoleUcastiNagGc není účast na GC");
    }

    public static function udalostDleRole(int $roleUcastiNagGc): string {
        if (!self::jeToUcastNaGc($roleUcastiNagGc)) {
            throw new \LogicException("Role (židle) s ID $roleUcastiNagGc v sobě nemá ročník a tím ani událost");
        }
        switch (abs($roleUcastiNagGc) % 100) {
            case 1 :
                return self::UDALOST_PRIHLASEN;
            case 2 :
                return self::UDALOST_PRITOMEN;
            case 3 :
                return self::UDALOST_ODJEL;
            default :
                throw new \RuntimeException("Role (židle) s ID $roleUcastiNagGc v sobě má neznámou událost");
        }
    }

    /**
     * Rozmysli, zda není lepší použít čitelnější @see \Gamecon\Role\Role::TYP_UCAST
     */
    public static function jeToUcastNaGc(int $role): bool {
        return $role < 0 && $role > self::KOEFICIENT_ROCNIKOVE_ROLE;
    }

    /**
     * Rozmysli, zda není lepší použít čitelnější @see \Gamecon\Role\Role::TYP_ROCNIKOVA
     */
    public static function jeToRocnikovaRole(int $role): bool {
        return $role <= self::KOEFICIENT_ROCNIKOVE_ROLE;
    }

    public static function jePouzeProTentoRocnik(int $idRole, int $rocnik = ROCNIK): bool {
        if (!self::jeToUcastNaGc($idRole) && !self::jeToRocnikovaRole($idRole)) {
            return false;
        }
        return self::rokDleRoleUcasti($idRole) === $rocnik;
    }

    public static function vsechnyRoleUcastiProRocnik(int $rocnik = ROCNIK): array {
        return [
            Role::PRIHLASEN_NA_LETOSNI_GC => self::pridejGcRocnikPrefix($rocnik, 'přihlášen'),
            Role::PRITOMEN_NA_LETOSNIM_GC => self::pridejGcRocnikPrefix($rocnik, 'přítomen'),
            Role::ODJEL_Z_LETOSNIHO_GC    => self::pridejGcRocnikPrefix($rocnik, 'odjel'),
        ];
    }

    private static function pridejGcRocnikPrefix(int $rocnik, string $nazev): string {
        return self::prefixRocniku($rocnik) . ' ' . $nazev;
    }

    public static function vsechnyRocnikoveRole(int $rocnik = ROCNIK): array {
        $idckaRocnikovychRoli = [
            self::LETOSNI_VYPRAVEC($rocnik),
            self::LETOSNI_ZAZEMI($rocnik),
            self::LETOSNI_INFOPULT($rocnik),
            self::LETOSNI_PARTNER($rocnik),
            self::LETOSNI_DOBROVOLNIK_SENIOR($rocnik),
            self::LETOSNI_STREDECNI_NOC_ZDARMA($rocnik),
            self::LETOSNI_NEDELNI_NOC_ZDARMA($rocnik),
            self::LETOSNI_NEODHLASOVAT($rocnik),
            self::LETOSNI_HERMAN($rocnik),
            self::LETOSNI_BRIGADNIK($rocnik),
        ];
        $vsechnyRocnikoveRole = [];
        foreach ($idckaRocnikovychRoli as $id) {
            $vsechnyRocnikoveRole[$id] = self::nazevRole($id);
        }
        return $vsechnyRocnikoveRole;
    }

    public function jmenoRole(): ?string {
        return $this->r['nazev_role'] ?? null;
    }

    public static function platiProRocnik(int $roleProRok, int $rocnik = ROCNIK): bool {
        return $roleProRok === self::JAKYKOLI_ROCNIK
            || self::platiPouzeProRocnik($roleProRok, $rocnik);
    }

    public static function platiPouzeProRocnik(int $roleProRok, int $rocnik = ROCNIK): bool {
        return $roleProRok === $rocnik;
    }

    public static function prefixRocniku(int $rocnik = ROCNIK): string {
        return 'GC' . $rocnik;
    }
}