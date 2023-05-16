<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum DebitorenRechnungArtAnzeigeEnum: int
{
    case ALLE = 0;
    case NUR_DOKUMENTE = 2;
    case NUR_ENTWUERFE_VORLAGEN = 3;

    public function description(): string
    {
        return match($this) {
            self::ALLE => 'Alle',
            self::NUR_DOKUMENTE => 'Nur Dokumente',
            self::NUR_ENTWUERFE_VORLAGEN => 'Nur Entwürfe/Vorlagen',
        };
    }
}
