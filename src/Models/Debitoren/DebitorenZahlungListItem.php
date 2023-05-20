<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use stdClass;

class DebitorenZahlungListItem
{
    protected string $zahlungId = '';
    protected string $adresseId = '';
    protected string $datum = '';
    protected string $belegNr = '';
    protected string $name = '';
    protected string $referenz = '';
    protected int $konto = 0;
    protected string $zahlung = '';
    protected string $minderung = '';

    public function __construct(
        string $zahlungId = '',
        string $adresseId = '',
        string $datum = '',
        string $belegNr = '',
        string $name = '',
        string $referenz = '',
        int $konto = 0,
        string $zahlung = '',
        string $minderung = '',
    ) {
        $this->zahlungId = $zahlungId;
        $this->adresseId = $adresseId;
        $this->datum = $datum;
        $this->belegNr = $belegNr;
        $this->name = $name;
        $this->referenz = $referenz;
        $this->konto = $konto;
        $this->zahlung = $zahlung;
        $this->minderung = $minderung;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Zahlung_ID,
            $response->Adresse_ID,
            $response->Datum,
            $response->BelegNr,
            $response->Name,
            $response->Referenz,
            $response->Konto,
            $response->Zahlung,
            $response->Minderung,
        );
    }

    public function getZahlungId(): string
    {
        return $this->zahlungId;
    }

    public function setZahlungId(string $zahlungId): void
    {
        $this->zahlungId = $zahlungId;
    }

    public function getAdresseId(): string
    {
        return $this->adresseId;
    }

    public function setAdresseId(string $adresseId): void
    {
        $this->adresseId = $adresseId;
    }

    public function getDatum(): string
    {
        return $this->datum;
    }

    public function setDatum(string $datum): void
    {
        $this->datum = $datum;
    }

    public function getBelegNr(): string
    {
        return $this->belegNr;
    }

    public function setBelegNr(string $belegNr): void
    {
        $this->belegNr = $belegNr;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getReferenz(): string
    {
        return $this->referenz;
    }

    public function setReferenz(string $referenz): void
    {
        $this->referenz = $referenz;
    }

    public function getKonto(): int
    {
        return $this->konto;
    }

    public function setKonto(int $konto): void
    {
        $this->konto = $konto;
    }

    public function getZahlung(): string
    {
        return $this->zahlung;
    }

    public function setZahlung(string $zahlung): void
    {
        $this->zahlung = $zahlung;
    }

    public function getMinderung(): string
    {
        return $this->minderung;
    }

    public function setMinderung(string $minderung): void
    {
        $this->minderung = $minderung;
    }

    public function __toArray(): array
    {
        return [
            'Zahlung_ID' => $this->getZahlungId(),
            'Adresse_ID' => $this->getAdresseId(),
            'Datum' => $this->getDatum(),
            'BelegNr' => $this->getBelegNr(),
            'Name' => $this->getName(),
            'Referenz' => $this->getReferenz(),
            'Konto' => $this->getKonto(),
            'Zahlung' => $this->getZahlung(),
            'Minderung' => $this->getMinderung(),
        ];
    }
}
