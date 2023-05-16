<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\Enums\SteuerSatzTypEnum;
use stdClass;

class OSSDatenItem
{
    protected string $isoCode;
    protected string $steuerSatz;
    protected SteuerSatzTypEnum $typ;

    public function __construct(string $isoCode, string $steuerSatz, SteuerSatzTypEnum $typ)
    {
        $this->isoCode = $isoCode;
        $this->steuerSatz = $steuerSatz;
        $this->typ = $typ;
    }

    public static function fromResponse(stdClass $response): OSSDatenItem
    {
        $typ = $response->Typ === 0 ? 1 : $response->Typ;

        return new self(
            $response->Isocode,
            $response->Steuersatz,
            SteuerSatzTypEnum::from($typ)
        );
    }

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getSteuerSatz(): string
    {
        return $this->steuerSatz;
    }

    public function setSteuerSatz(string $steuerSatz): void
    {
        $this->steuerSatz = $steuerSatz;
    }

    public function getTyp(): SteuerSatzTypEnum
    {
        return $this->typ;
    }

    public function setTyp(int $typ = 1): void
    {
        $this->typ = SteuerSatzTypEnum::from($typ);
    }

    public function toArray(): array
    {
        return [
            'Isocode' => $this->getIsoCode(),
            'Steuersatz' => $this->getSteuerSatz(),
            'Typ' => $this->getTyp()->value,
        ];
    }
}
