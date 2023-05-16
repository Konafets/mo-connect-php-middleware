<?php

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum FestschreibStatusEnum: int
{
    case ERFASST = 1;
    case FESTGESCHRIEBEN = 2;
    case ALLE = 4;

    public function description(): string
    {
        return match($this) {
            self::ERFASST => 'Erfasst',
            self::FESTGESCHRIEBEN => 'Festgeschrieben',
            self::ALLE => 'Alle',
        };
    }
}
