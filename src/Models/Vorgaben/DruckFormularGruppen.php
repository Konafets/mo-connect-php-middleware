<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;

class DruckFormularGruppen
{
    use ResponseTrait;

    protected array $groups = [
        1008 => 'Verkauf',
        1014 => 'Einkauf',
    ];

    protected int $group;

    public function __construct(int $group)
    {
        $this->group = $group;
    }

    public function getGroup(): int
    {
        return $this->group;
    }

    public function setGroup(int $group): void
    {
        $this->group = $group;
    }
}
