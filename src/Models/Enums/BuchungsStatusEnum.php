<?php

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum BuchungsStatusEnum: int
{
    case NICHT_FESTGESCHRIEBEN = 1;
    case FESTGESCHRIEBEN = 2;
    case ALLE = 4;

    public function description(): string
    {
        return match($this) {
            self::NICHT_FESTGESCHRIEBEN => 'Nicht festgeschrieben',
            self::FESTGESCHRIEBEN => 'Festgeschrieben',
            self::ALLE => 'Alle',
        };
    }
}
