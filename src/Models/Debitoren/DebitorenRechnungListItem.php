<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Enums\DebitorenRechnungArtEnum;
use stdClass;

class DebitorenRechnungListItem
{
    protected string $postenId = '';
    protected string $adresseId = '';
    protected DebitorenRechnungArtEnum $rechnungsArt;

    protected string $datum = '';
    protected string $belegNr = '';
    protected string $name = '';
    protected string $referenz = '';
    protected string $konto = '';
    protected string $brutto = '';
    protected string $bezahlt = '';
    protected string $offen = '';
    protected string $projectId = '';
    protected string $projectNr = '';

    public function __construct(
        string $postenId = '',
        string $adresseId = '',
        DebitorenRechnungArtEnum $rechnungsArt = DebitorenRechnungArtEnum::DEBITOR_RECHNUNG,
        string $datum = '',
        string $belegNr = '',
        string $name = '',
        string $referenz = '',
        string $konto = '',
        string $brutto = '',
        string $bezahlt = '',
        string $offen = '',
        string $projectId = '',
        string $projectNr = '',
    ) {
        $this->postenId = $postenId;
        $this->adresseId = $adresseId;
        $this->rechnungsArt = $rechnungsArt;
        $this->datum = $datum;
        $this->belegNr = $belegNr;
        $this->name = $name;
        $this->referenz = $referenz;
        $this->konto = $konto;
        $this->brutto = $brutto;
        $this->bezahlt = $bezahlt;
        $this->offen = $offen;
        $this->projectId = $projectId;
        $this->projectNr = $projectNr;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Posten_ID,
            $response->Adresse_ID,
            $response->RechnungArt,
            $response->Datum,
            $response->BelegNr,
            $response->Name,
            $response->Referenz,
            $response->Konto,
            $response->Brutto,
            $response->Bezahlt,
            $response->Offen,
            $response->Projekt_ID,
            $response->ProjektNr,
        );
    }

    public function getPostenId(): string
    {
        return $this->postenId;
    }

    public function setPostenId(string $postenId): void
    {
        $this->postenId = $postenId;
    }

    public function getAdresseId(): string
    {
        return $this->adresseId;
    }

    public function setAdresseId(string $adresseId): void
    {
        $this->adresseId = $adresseId;
    }

    public function getRechnungsArt(): DebitorenRechnungArtEnum
    {
        return $this->rechnungsArt;
    }

    public function setRechnungsArt(DebitorenRechnungArtEnum $rechnungsArt): void
    {
        $this->rechnungsArt = $rechnungsArt;
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

    public function getKonto(): string
    {
        return $this->konto;
    }

    public function setKonto(string $konto): void
    {
        $this->konto = $konto;
    }

    public function getBrutto(): string
    {
        return $this->brutto;
    }

    public function setBrutto(string $brutto): void
    {
        $this->brutto = $brutto;
    }

    public function getBezahlt(): string
    {
        return $this->bezahlt;
    }

    public function setBezahlt(string $bezahlt): void
    {
        $this->bezahlt = $bezahlt;
    }

    public function getOffen(): string
    {
        return $this->offen;
    }

    public function setOffen(string $offen): void
    {
        $this->offen = $offen;
    }

    public function getProjectId(): string
    {
        return $this->projectId;
    }

    public function setProjectId(string $projectId): void
    {
        $this->projectId = $projectId;
    }

    public function getProjectNr(): string
    {
        return $this->projectNr;
    }

    public function setProjectNr(string $projectNr): void
    {
        $this->projectNr = $projectNr;
    }

    public function __toArray(): array
    {
        return [
            'Posten_ID' => $this->getPostenId(),
            'Adresse_ID' => $this->getAdresseId(),
            'RechnungArt' => $this->getRechnungsArt(),
            'Datum' => $this->getDatum(),
            'BelegNr' => $this->getBelegNr(),
            'Name' => $this->getName(),
            'Referenz' => $this->getReferenz(),
            'Konto' => $this->getKonto(),
            'Brutto' => $this->getBrutto(),
            'Bezahlt' => $this->getBezahlt(),
            'Offen' => $this->getOffen(),
            'Projekt_ID' => $this->getProjectId(),
            'ProjektNr' => $this->getProjectNr(),
        ];
    }
}
