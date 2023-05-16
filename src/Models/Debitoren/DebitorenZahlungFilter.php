<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use stdClass;

class DebitorenZahlungFilter
{
    protected string $adresseId = '';
    protected string $datumVon = '';
    protected string $datumBis = '';
    protected string $rechnungsNr = '';
    protected string $text = '';
    protected string $referenz = '';

    public function __construct(
        string $adresseId = '',
        string $datumVon = '',
        string $datumBis = '',
        string $rechnungsNr = '',
        string $text = '',
        string $referenz = '',
    ) {
        $this->adresseId = $adresseId;
        $this->datumVon = $datumVon;
        $this->datumBis = $datumBis;
        $this->rechnungsNr = $rechnungsNr;
        $this->text = $text;
        $this->referenz = $referenz;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Adresse_ID,
            $response->DatumVon,
            $response->DatumBis,
            $response->RechnungsNr,
            $response->Text,
            $response->Referenz,
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

    public function getReferenz(): string
    {
        return $this->referenz;
    }

    public function setReferenz(string $referenz): void
    {
        $this->referenz = $referenz;
    }

    public function __toArray(): array
    {
        return [
            'Adresse_ID' => $this->getAdresseId(),
            'DatumVon' => $this->getDatumVon(),
            'DatumBis' => $this->getDatumBis(),
            'RechnungsNr' => $this->getRechnungsNr(),
            'Text' => $this->getText(),
            'Referenz' => $this->getReferenz(),
        ];
    }
}
