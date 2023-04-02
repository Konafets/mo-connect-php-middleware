<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum AdresseStatusEnum: int
{
    case OHNE_STATUS = -2;
    case KUNDE_ODER_LIEFERANT = -1;
    case KEIN_KUNDE_ODER_LIEFERANT = 0;
    case AKTIVER_KUNDE_ODER_LIEFERANT = 1;
    case INAKTIVER_KUNDE_ODER_LIEFERANT = 2;
    case GESPERRTER_KUNDE_ODER_LIEFERANT = 3;

    public function description(): string
    {
        return match($this) {
            self::OHNE_STATUS => 'ohne Status',
            self::KUNDE_ODER_LIEFERANT => 'Ist Kunde bzw. Lieferant',
            self::KEIN_KUNDE_ODER_LIEFERANT => 'Ist kein Kunde bzw. Lieferant',
            self::AKTIVER_KUNDE_ODER_LIEFERANT => 'Ist aktiver Kunde bzw. Lieferant',
            self::INAKTIVER_KUNDE_ODER_LIEFERANT => 'Ist inaktiver Kunde bzw. Lieferant',
            self::GESPERRTER_KUNDE_ODER_LIEFERANT => 'Ist gesperrter Kunde bzw. Lieferant',
        };
    }

}


