<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum SteuerGebietEnum: int
{
    case INLAND = 1;
    case EU_AUSLAND = 2;
    case AUSLAND = 3;
    case STEUERFREI = 4;
    case EU_AUSLAND_OSS = 5;

    public function description(): string
    {
        return match ($this) {
            self::INLAND => 'Inland',
            self::EU_AUSLAND => 'EU-Ausland',
            self::AUSLAND => 'Ausland',
            self::STEUERFREI => 'Steuerfrei',
            self::EU_AUSLAND_OSS => 'EU-Ausland-OSS',
        };
    }
}


