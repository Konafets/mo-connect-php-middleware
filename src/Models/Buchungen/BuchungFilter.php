<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use stdClass;

class BuchungFilter
{
    protected string $suchtext = '';

    protected string $datumVon = '';

    protected string $datumBis = '';

    protected FestschreibStatusEnum $festschreibeStatus;

    protected string $belegNr = '';

    protected int $konto = 0;

    protected int $kontoSoll = 0;

    protected int $kontoHaben = 0;

    public function __construct(
        string $suchtext = '',
        string $datumVon = '',
        string $datumBis = '',
        FestschreibStatusEnum $festschreibeStatus = FestschreibStatusEnum::ALLE,
        string $belegNummer = '',
        int $konto = 0,
        int $kontoSoll = 0,
        int $kontoHaben= 0,
    ) {
        $this->suchtext = $suchtext;
        $this->datumVon = $datumVon;
        $this->datumBis = $datumBis;
        $this->festschreibeStatus = $festschreibeStatus;
        $this->belegNr = $belegNummer;
        $this->konto = $konto;
        $this->kontoSoll = $kontoSoll;
        $this->kontoHaben = $kontoHaben;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Suchtext,
            $response->DatumVon,
            $response->DatumBis,
            FestschreibStatusEnum::from((int) $response->FestschreibStatus),
            $response->BelegNr,
            $response->Konto,
            $response->KontoSoll,
            $response->KontoHaben,
        );
    }

    public function getSuchtext(): string
    {
        return $this->suchtext;
    }

    public function setSuchtext(string $suchtext): void
    {
        $this->suchtext = $suchtext;
    }

    public function getDatumVon(): string
    {
        return $this->datumVon;
    }

    public function setDatumVon(string $datumVon): void
    {
        $this->datumVon = $datumVon;
    }

    public function getDatumBis(): string
    {
        return $this->datumBis;
    }

    public function setDatumBis(string $datumBis): void
    {
        $this->datumBis = $datumBis;
    }

    public function getFestschreibeStatus(): int
    {
        return $this->festschreibeStatus->value;
    }

    public function setFestschreibeStatus(FestschreibStatusEnum $festschreibeStatus): void
    {
        $this->festschreibeStatus = $festschreibeStatus;
    }

    public function getBelegNr(): string
    {
        return $this->belegNr;
    }

    public function setBelegNr(string $belegNr): void
    {
        $this->belegNr = $belegNr;
    }

    public function getKonto(): int
    {
        return $this->konto;
    }

    public function setKonto(int $konto): void
    {
        $this->konto = $konto;
    }

    public function getKontoSoll(): int
    {
        return $this->kontoSoll;
    }

    public function setKontoSoll(int $kontoSoll): void
    {
        $this->kontoSoll = $kontoSoll;
    }

    public function getKontoHaben(): int
    {
        return $this->kontoHaben;
    }

    public function setKontoHaben(int $kontoHaben): void
    {
        $this->kontoHaben = $kontoHaben;
    }

    public function __toArray(): array
    {
        return [
            'Suchtext' => $this->getSuchtext(),
            'DatumVon' => $this->getDatumVon(),
            'DatumBis' => $this->getDatumBis(),
            'FestschreibStatus' => $this->getFestschreibeStatus(),
            'BelegNr' => $this->getBelegNr(),
            'Konto' => $this->getKonto(),
            'KontoSoll' => $this->getKontoSoll(),
            'KontoHaben' => $this->getKontoHaben(),
        ];
    }
}
