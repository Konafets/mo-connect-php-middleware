<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

class Location
{
    protected string $strasse = '';
    protected string $plz = '';
    protected string $ort = '';

    public function __construct(string $strasse, string $plz, string $ort)
    {
        $this->strasse = $strasse;
        $this->plz = $plz;
        $this->ort = $ort;
    }

    public function getStrasse(): string
    {
        return $this->strasse;
    }

    public function setStrasse(string $strasse): void
    {
        $this->strasse = $strasse;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function setPlz(string $plz): void
    {
        $this->plz = $plz;
    }

    public function getOrt(): string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): void
    {
        $this->ort = $ort;
    }
}
