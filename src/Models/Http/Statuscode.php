<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Http;

class Statuscode
{
    public const OK = 0;
    public const COMMON_ERROR = 1;
    public const ACCESS_ERROR = 2;
    public const UNKNOWN_FUNCTION = 3;
    public const PARAMETER_ERROR = 4;

    public const API_ERRORS = [
        0 => 'alles OK',
        1 => 'allgemeiner Fehler',
        2 => 'Fehler Zugriffsrechte',
        3 => 'Funktion unbekannt',
        4 => 'Parameterfehler',
    ];

    protected int $statusCode;

    public function __construct($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function isOk(): bool
    {
        return $this->statusCode === self::OK;
    }

    public function isCommonError(): bool
    {
        return $this->statusCode === self::COMMON_ERROR;
    }

    public function isAccessError(): bool
    {
        return $this->statusCode === self::ACCESS_ERROR;
    }

    public function isFunctionUnknown(): bool
    {
        return $this->statusCode === self::UNKNOWN_FUNCTION;
    }

    public function isParameterError(): bool
    {
        return $this->statusCode === self::PARAMETER_ERROR;
    }
}
