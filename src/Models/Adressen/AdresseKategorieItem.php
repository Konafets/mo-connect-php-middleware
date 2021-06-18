<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

class AdresseKategorieItem
{
    protected string $name = '';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self($response->Name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
