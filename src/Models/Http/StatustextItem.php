<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Http;

use stdClass;

class StatustextItem
{
    protected string $statustext = '';

    public function __construct(string $statustext)
    {
        $this->statustext = $statustext;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Statustext,
        );
    }

    public function getStatustext(): string
    {
        return $this->statustext;
    }

    public function setStatustext(string $statustext): void
    {
        $this->statustext = $statustext;
    }
}
