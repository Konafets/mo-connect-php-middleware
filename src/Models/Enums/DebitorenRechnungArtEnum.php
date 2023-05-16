<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum DebitorenRechnungArtEnum: int
{
    case DEBITOR_RECHNUNG = 0;
    case DEBITOR_GUTSCHRIFT = 1;

    public function description(): string
    {
        return match($this) {
            self::DEBITOR_RECHNUNG => 'DebitorRechnung',
            self::DEBITOR_GUTSCHRIFT => 'DebitorGutschrift',
        };
    }
}
