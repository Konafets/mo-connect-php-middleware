<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

use stdClass;

class StatustextItem
{
    use ResponseTrait;

    protected string $statustext = '';

    public function __construct(string $statustext)
    {
        $this->statustext = $statustext;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

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
