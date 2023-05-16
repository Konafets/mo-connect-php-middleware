<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Enums;

enum SteuerSatzTypEnum: int
{
    case STEUER_NORMAL = 1;
    case STEUER_ERMAESSIGT = 2;

    public function description(): string
    {
        return match ($this) {
            self::STEUER_NORMAL => 'Steuer normal',
            self::STEUER_ERMAESSIGT => 'Steuer ermäßigt',
        };
    }
}


