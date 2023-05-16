<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Enums\DebitorenbelegStatusEnum;
use ArrobaIt\MoConnectApi\Models\Enums\DebitorenRechnungArtAnzeigeEnum;
use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use stdClass;

class DebitorenRechnungFilter
{

    protected string $adresseId = '';

    protected string $datumVon = '';

    protected string $datumBis = '';

    protected DebitorenRechnungArtAnzeigeEnum $rechnungsArt;

    protected string $rechnungsNr = '';

    protected string $text = '';

    protected int $debitorenKonto = 0;

    protected int $erfolgsKonto = 0;

    protected string $referenz = '';

    protected FestschreibStatusEnum $festschreibeStatus;

    protected DebitorenbelegStatusEnum $debitorenbelegStatus;

    public function __construct(
        string $adresseId = '',
        string $datumVon = '',
        string $datumBis = '',
        DebitorenRechnungArtAnzeigeEnum $rechnungsArt = DebitorenRechnungArtAnzeigeEnum::ALLE,
        string $rechnungsNr = '',
        string $text = '',
        int $debitorenKonto = 0,
        int $erfolgsKonto = 0,
        string $referenz = '',
        FestschreibStatusEnum $festschreibeStatus = FestschreibStatusEnum::ALLE,
        DebitorenbelegStatusEnum $debitorenbelegStatus = DebitorenbelegStatusEnum::ALLE,
    ) {
        $this->adresseId = $adresseId;
        $this->datumVon = $datumVon;
        $this->datumBis = $datumBis;
        $this->rechnungsArt = $rechnungsArt;
        $this->rechnungsNr = $rechnungsNr;
        $this->text = $text;
        $this->debitorenKonto = $debitorenKonto;
        $this->erfolgsKonto = $erfolgsKonto;
        $this->referenz = $referenz;
        $this->festschreibeStatus = $festschreibeStatus;
        $this->debitorenbelegStatus = $debitorenbelegStatus;
    }

    public static function fromResponse(stdClass $response): self
    {
        $debitorenBelegStatus = $response->DebitorenbelegStatus === '' ? DebitorenbelegStatusEnum::ALLE : DebitorenbelegStatusEnum::from($response->DebitorenbelegStatus);

        return new self(
            $response->Adresse_ID,
            $response->DatumVon,
            $response->DatumBis,
            DebitorenRechnungArtAnzeigeEnum::from((int) $response->Rechnungsart),
            $response->RechnungsNr,
            $response->Text,
            $response->Debitorenkonto,
            $response->Erfolgskonto,
            $response->Referenz,
            FestschreibStatusEnum::from((int) $response->FestschreibStatus),
            $debitorenBelegStatus,
        );
    }

    public function getAdresseId(): string
    {
        return $this->adresseId;
    }

    public function setAdresseId(string $adresseId): void
    {
        $this->adresseId = $adresseId;
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

    public function getRechnungsArt(): DebitorenRechnungArtAnzeigeEnum
    {
        return $this->rechnungsArt;
    }

    public function setRechnungsArt(DebitorenRechnungArtAnzeigeEnum $rechnungsArt): void
    {
        $this->rechnungsArt = $rechnungsArt;
    }

    public function getRechnungsNr(): string
    {
        return $this->rechnungsNr;
    }

    public function setRechnungsNr(string $rechnungsNr): void
    {
        $this->rechnungsNr = $rechnungsNr;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getDebitorenKonto(): int
    {
        return $this->debitorenKonto;
    }

    public function setDebitorenKonto(int $debitorenKonto): void
    {
        $this->debitorenKonto = $debitorenKonto;
    }

    public function getErfolgsKonto(): int
    {
        return $this->erfolgsKonto;
    }

    public function setErfolgsKonto(int $erfolgsKonto): void
    {
        $this->erfolgsKonto = $erfolgsKonto;
    }

    public function getReferenz(): string
    {
        return $this->referenz;
    }

    public function setReferenz(string $referenz): void
    {
        $this->referenz = $referenz;
    }

    public function getFestschreibeStatus(): int
    {
        return $this->festschreibeStatus->value;
    }

    public function setFestschreibeStatus(FestschreibStatusEnum $festschreibeStatus): void
    {
        $this->festschreibeStatus = $festschreibeStatus;
    }

    public function getDebitorenbelegStatus(): DebitorenbelegStatusEnum
    {
        return $this->debitorenbelegStatus;
    }

    public function setDebitorenbelegStatus(DebitorenbelegStatusEnum $debitorenbelegStatus): void
    {
        $this->debitorenbelegStatus = $debitorenbelegStatus;
    }

    public function __toArray(): array
    {
        return [
            'Adresse_ID' => $this->getAdresseID(),
            'DatumVon' => $this->getDatumVon(),
            'DatumBis' => $this->getDatumBis(),
            'Rechnungsart' => $this->getRechnungsArt(),
            'RechnungsNr' => $this->getRechnungsNr(),
            'Text' => $this->getText(),
            'Debitorenkonto' =>	$this->getDebitorenKonto(),
            'Erfolgskonto' =>	$this->getErfolgsKonto(),
            'Referenz' => $this->getReferenz(),
            'FestschreibStatus' => $this->getFestschreibeStatus(),
            'DebitorenbelegStatus' =>	$this->getDebitorenbelegStatus(),
        ];
    }
}
