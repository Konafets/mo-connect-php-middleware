<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class SteuersatzListItem
{
    use ResponseTrait;

    protected string $name = '';

    protected string $beschreibung = '';

    protected string $steuersatz = '';

    protected bool $gesperrt = false;

    public function __construct(string $name, string $beschreibung, string $steuersatz, bool $gesperrt)
    {
        $this->name = $name;
        $this->beschreibung = $beschreibung;
        $this->steuersatz = $steuersatz;
        $this->gesperrt = $gesperrt;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->Name,
            $response->Beschreibung,
            $response->Steuersatz,
            $response->Gesperrt,
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

    public function getBeschreibung(): string
    {
        return $this->beschreibung;
    }

    public function setBeschreibung(string $beschreibung): void
    {
        $this->beschreibung = $beschreibung;
    }

    public function getSteuersatz(): string
    {
        return $this->steuersatz;
    }

    public function setSteuersatz(string $steuersatz): void
    {
        $this->steuersatz = $steuersatz;
    }

    public function isGesperrt(): bool
    {
        return $this->gesperrt;
    }

    public function setGesperrt(bool $gesperrt): void
    {
        $this->gesperrt = $gesperrt;
    }
}
