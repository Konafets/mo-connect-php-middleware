<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum DebitorenRechnungKalkbasisEnum: string
{
    case NETTO = '0';
    case BRUTTO = '1';

    public function description(): string
    {
        return match($this) {
            self::NETTO => 'Netto',
            self::BRUTTO => 'Brutto',
        };
    }
}
