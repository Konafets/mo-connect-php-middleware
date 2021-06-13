<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class WaehrungListItem
{
    use ResponseTrait;

    protected string $name = '';

    protected string $isoCode = '';

    protected string $kurs = '';

    public function __construct(string $name, string $isoCode, string $kurs)
    {
        $this->name = $name;
        $this->isoCode = $isoCode;
        $this->kurs = $kurs;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->Name,
            $response->Isocode,
            $response->Kurs,
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getKurs(): string
    {
        return $this->kurs;
    }

    public function setKurs(string $kurs): void
    {
        $this->kurs = $kurs;
    }
}
