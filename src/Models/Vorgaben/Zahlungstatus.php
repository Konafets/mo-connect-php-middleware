<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class Zahlungstatus
{
    use ResponseTrait;

    protected const STATES = [
        0 => 'Ohne',
        1 => 'Offen',
        2 => 'Teilweise',
        3 => 'Bezahlt',
    ];

    protected int $status;

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
    }

    public function __construct(int $state)
    {
        $this->status = $state;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
