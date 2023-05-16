<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class BuchungJournalItem
{
    /**
     * Neu ab Version 18.1.0
     *
     * @var int
     */
    protected string $journalNummer = '';
    protected int $konto = 0;
    protected string $kontoBezeichnung = '';
    protected string $betragSoll = '';
    protected string $betragHaben = '';
    protected string $steuersatz = '';
    protected string $text = '';
    protected string $kostenstelle1 = '';
    protected string $kostenstelle2 = '';
    protected string $fwSoll = '';
    protected string $fwHaben = '';
    protected OSSDatenItem $ossDatenItem;

    public function __construct(
        string $journalNummer,
        int $konto,
        string $kontoBezeichnung,
        string $betragSoll,
        string $betragHaben,
        string $steuersatz,
        string $text,
        string $kostenstelle1,
        string $kostenstelle2,
        string $fwSoll,
        string $fwHaben,
        OSSDatenItem $ossDatenItem,
    ) {
        $this->journalNummer = $journalNummer;
        $this->konto = $konto;
        $this->kontoBezeichnung = $kontoBezeichnung;
        $this->betragSoll = $betragSoll;
        $this->betragHaben = $betragHaben;
        $this->steuersatz = $steuersatz;
        $this->text = $text;
        $this->kostenstelle1 = $kostenstelle1;
        $this->kostenstelle2 = $kostenstelle2;
        $this->fwSoll = $fwSoll;
        $this->fwHaben = $fwHaben;
        $this->ossDatenItem = $ossDatenItem;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Journalnummer,
            $response->Konto,
            $response->Kontobezeichnung,
            $response->BetragSoll,
            $response->BetragHaben,
            $response->Steuersatz,
            $response->Text,
            $response->Kostenstelle1,
            $response->Kostenstelle2,
            $response->FW_Soll,
            $response->FW_Haben,
            OSSDatenItem::fromResponse($response->OSS_Daten->OSSDatenItem),
        );
    }

    public function getJournalNummer(): string
    {
        return $this->journalNummer;
    }

    public function setJournalNummer(string $journalNummer): void
    {
        $this->journalNummer = $journalNummer;
    }

    public function getKonto(): int
    {
        return $this->konto;
    }

    public function setKonto(int $konto): void
    {
        $this->konto = $konto;
    }

    public function getKontoBezeichnung(): string
    {
        return $this->kontoBezeichnung;
    }

    public function setKontoBezeichnung(string $kontoBezeichnung): void
    {
        $this->kontoBezeichnung = $kontoBezeichnung;
    }

    public function getBetragSoll(): string
    {
        return $this->betragSoll;
    }

    public function setBetragSoll(string $betragSoll): void
    {
        $this->betragSoll = $betragSoll;
    }

    public function getBetragHaben(): string
    {
        return $this->betragHaben;
    }

    public function setBetragHaben(string $betragHaben): void
    {
        $this->betragHaben = $betragHaben;
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

    public function getKostenstelle1(): string
    {
        return $this->kostenstelle1;
    }

    public function setKostenstelle1(string $kostenstelle1): void
    {
        $this->kostenstelle1 = $kostenstelle1;
    }

    public function getKostenstelle2(): string
    {
        return $this->kostenstelle2;
    }

    public function setKostenstelle2(string $kostenstelle2): void
    {
        $this->kostenstelle2 = $kostenstelle2;
    }

    public function getFwSoll(): string
    {
        return $this->fwSoll;
    }

    public function setFwSoll(string $fwSoll): void
    {
        $this->fwSoll = $fwSoll;
    }

    public function getFwHaben(): string
    {
        return $this->fwHaben;
    }

    public function setFwHaben(string $fwHaben): void
    {
        $this->fwHaben = $fwHaben;
    }

    public function getOssDatenItem(): OSSDatenItem
    {
        return $this->ossDatenItem;
    }

    public function setOssDatenItem(OSSDatenItem $ossDatenItem): void
    {
        $this->ossDatenItem = $ossDatenItem;
    }
}
