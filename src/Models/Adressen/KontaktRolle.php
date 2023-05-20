<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

class KontaktRolle
{
    protected const ROLLEN = [
        1 => 'Verkauf(allgemein)',
        2 => 'Einkauf(allgemein)',
        3 => 'Mahnungen',
        4 => 'Angebote',
        5 => 'Auftragsbestätigungen',
        6 => 'Lieferscheine',
        7 => 'Korrekturrechnungen',
        8 => 'Proformarechnungen',
        9 => 'Abschlagsrechnungen',
        10 => 'Verkaufsrechnungen',
        11 => 'Storno Verkaufsrechnungen',
        12 => 'Bestellanfragen',
        13 => 'Bestellungen',
        14 => 'Wareneingänge',
        15 => 'Lieferantengutschriften',
        16 => 'Rücksendungen',
        17 => 'Eingangsrechnungen',
        18 => 'Storno Eingangsrechnungen',
        19 => 'Briefe',
    ];

    protected int $rolle;

    public function __construct(int $rolle)
    {
        $this->rolle = $rolle;
    }

    public function getRolle(): int
    {
        return $this->rolle;
    }

    public function setRolle(int $rolle): void
    {
        $this->rolle = $rolle;
    }

    public function getBeschreibung(): string
    {
        return self::ROLLEN[$this->getRolle()] ?? '';
    }

    public function __toString(): string
    {
        return $this->getBeschreibung();
    }

    public function __toArray(): array
    {
        return [
            'KontaktRolle' => $this->getRolle(),
        ];
    }
}
