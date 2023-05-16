<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum ZahlungsartEnum: int
{
    case KEINE = 0;
    case BAR = 1;
    case LASTSCHRIFT = 2;
    case KREDITKARTE = 3;
    case UEBERWEISUNG = 4;
    case SCHECK = 5;
    case EC_KARTE = 6;

    public function description(): string
    {
        return match ($this) {
            self::KEINE => 'Keine',
            self::BAR => 'Bar',
            self::LASTSCHRIFT => 'Lastschrift',
            self::KREDITKARTE => 'Kreditkarte',
            self::UEBERWEISUNG => 'Überweisung',
            self::SCHECK => 'Scheck',
            self::EC_KARTE => 'EC-Karte',
        };
    }
}
