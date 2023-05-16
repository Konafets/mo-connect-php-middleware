<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class FestschreibStatus
{
    use ResponseTrait;

    protected array $states = [
        1 => 'Erfasst',
        2 => 'Festgeschrieben',
        4 => 'Alle',
    ];

    protected int $state;

    public function __construct(int $state)
    {
        $this->state = $state;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

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
