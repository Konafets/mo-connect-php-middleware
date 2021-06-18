<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class Steuergebiet
{
    use ResponseTrait;

    protected const GEBIETE = [
        1 => 'Inland',
        2 => 'EU-Ausland',
        3 => 'Ausland',
        4 => 'Steuerfrei',
    ];

    protected int $gebiet;

    public function __construct(int $gebiet = 1)
    {
        $this->gebiet = $gebiet;
    }

    public function getGebiet(): int
    {
        return $this->gebiet;
    }

    public function setGebiet(int $gebiet): void
    {
        $this->gebiet = $gebiet;
    }

    public function getBeschreibung(): string
    {
        return self::GEBIETE[$this->getGebiet()] ?? '';
    }

    public function __toString(): string
    {
        return $this->getBeschreibung();
    }
}
