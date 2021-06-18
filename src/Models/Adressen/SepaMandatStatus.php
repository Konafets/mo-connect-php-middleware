<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

/**
 * Class SepaMandatStatus
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatStatus
{
    protected array $states = [
        1 => 'Neu',
        2 => 'Aktiv',
        3 => 'InAktiv',
        4 => 'Widerrufen',
    ];

    protected int $state;

    public function __construct(int $state)
    {
        $this->state = $state;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self();
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function setState(int $state): void
    {
        $this->state = $state;
    }
}
