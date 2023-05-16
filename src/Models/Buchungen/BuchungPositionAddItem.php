<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class BuchungPositionAddItem
{
    protected string $betrag = '';

    protected int $kontoSoll = 0;

    protected int $kontoHaben = 0;

    protected string $kostenStelle1 = '';

    protected string $kostenStelle2 = '';

    protected string $steuersatz = '';

    protected string $text = '';

    /**
     * Derzeit nicht in Benutzung
     *
     * @var int
     */
    protected int $buchungBetragBasis = 0;

    protected OSSDatenItem $ossDaten;

    public function __construct(
        string $betrag,
        int $kontoSoll,
        int $kontoHaben,
        string $kostenStelle1,
        string $kostenStelle2,
        string $steuersatz,
        string $text,
        int $buchungBetragBasis,
        OSSDatenItem $ossDaten,
    ) {
        $this->betrag = $betrag;
        $this->kontoSoll = $kontoSoll;
        $this->kontoHaben = $kontoHaben;
        $this->kostenStelle1 = $kostenStelle1;
        $this->kostenStelle2 = $kostenStelle2;
        $this->steuersatz = $steuersatz;
        $this->text = $text;
        $this->buchungBetragBasis = $buchungBetragBasis;
        $this->ossDaten = $ossDaten;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Betrag,
            $response->KontoSoll,
            $response->KontoHaben,
            $response->Kostenstelle1,
            $response->Kostenstelle2,
            $response->Steuersatz,
            $response->Text,
            $response->BuchungBetragBasis,
            OSSDatenItem::fromResponse($response->OSS_Daten->OSSDatenItem),
        );
    }

    public function getBetrag(): string
    {
        return $this->betrag;
    }

    public function setBetrag(string $betrag): void
    {
        $this->betrag = $betrag;
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

    public function getKostenStelle1(): string
    {
        return $this->kostenStelle1;
    }

    public function setKostenStelle1(string $kostenStelle1): void
    {
        $this->kostenStelle1 = $kostenStelle1;
    }

    public function getKostenStelle2(): string
    {
        return $this->kostenStelle2;
    }

    public function setKostenStelle2(string $kostenStelle2): void
    {
        $this->kostenStelle2 = $kostenStelle2;
    }

    public function getSteuersatz(): string
    {
        return $this->steuersatz;
    }

    public function setSteuersatz(string $steuersatz): void
    {
        $this->steuersatz = $steuersatz;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getBuchungBetragBasis(): int
    {
        return $this->buchungBetragBasis;
    }

    public function setBuchungBetragBasis(int $buchungBetragBasis): void
    {
        $this->buchungBetragBasis = $buchungBetragBasis;
    }

    public function getOssDaten(): OSSDatenItem
    {
        return $this->ossDaten;
    }

    public function setOssDaten(OSSDatenItem $ossDaten): void
    {
        $this->ossDaten = $ossDaten;
    }

    public function toArray(): array
    {
        return [
            'Betrag' => $this->getBetrag(),
            'KontoSoll' => $this->getKontoSoll(),
            'KontoHaben' => $this->getKontoHaben(),
            'Kostenstelle1' => $this->getKostenStelle1(),
            'Kostenstelle2' => $this->getKostenStelle2(),
            'Steuersatz' => $this->getSteuersatz(),
            'Text' => $this->getText(),
            'BuchungBetragBasis' => $this->getBuchungBetragBasis(),
            'OSS_Daten' => [
                'OSSDatenItem' => $this->getOssDaten()->toArray()
            ],
        ];
    }
}
