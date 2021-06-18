<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class AdresseStatus
{
    use ResponseTrait;

    protected const STATES = [
        '-2' => 'ohne Status',
        '-1' => 'Ist Kunde bzw. Lieferant',
        0 => 'Ist kein Kunde bzw. Lieferant',
        1 => 'Ist aktiver Kunde bzw. Lieferant',
        2 => 'Ist inaktiver Kunde bzw. Lieferant',
        3 => 'Ist gesperrter Kunde bzw. Lieferant',
    ];

    protected int $status = 0;

    public function __construct(int $status = 0)
    {
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getBeschreibung(): string
    {
        return self::STATES[$this->getStatus()] ?? '';
    }

    public function __toString(): string
    {
        return $this->getBeschreibung();
    }

    public function toArray(): array
    {
        return [
            'AdresseStatus' => $this->getStatus(),
        ];
    }
}
