<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class KostenstelleListItem
{
    use ResponseTrait;

    protected string $name = '';

    protected string $beschreibung = '';

    protected string $bemerkung = '';

    public function __construct(string $name, string $beschreibung, string $bemerkung)
    {
        $this->name = $name;
        $this->beschreibung = $beschreibung;
        $this->bemerkung = $bemerkung;
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

    public function getBemerkung(): string
    {
        return $this->bemerkung;
    }

    public function setBemerkung(string $bemerkung): void
    {
        $this->bemerkung = $bemerkung;
    }
}
