<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Buchungen\OSSDatenItem;
use stdClass;

class DebitorenRechnungPositionAddItem
{
    protected string $text = '';
    protected string $betragBruttoFw = '';
    protected string $betragNettoFw = '';
    protected int $ertragsKonto = 0;
    protected string $kostenstelle1 = '';
    protected string $kostenstelle2 = '';
    protected string $steuersatz = '';
    protected OSSDatenItem $ossDatenItem;

    public function __construct(
        string $text,
        string $betragBruttoFw,
        string $betragNettoFw,
        int $ertragsKonto,
        string $kostenstelle1,
        string $kostenstelle2,
        string $steuersatz,
        OSSDatenItem $ossDatenItem,
    ) {
        $this->text = $text;
        $this->betragBruttoFw = $betragBruttoFw;
        $this->betragNettoFw = $betragNettoFw;
        $this->ertragsKonto = $ertragsKonto;
        $this->kostenstelle1 = $kostenstelle1;
        $this->kostenstelle2 = $kostenstelle2;
        $this->steuersatz = $steuersatz;
        $this->ossDatenItem = $ossDatenItem;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Text,
            $response->BetragBruttoFW,
            $response->BetragNettoFW,
            $response->Ertragskonto,
            $response->Kostenstelle1,
            $response->Kostenstelle2,
            $response->Steuersatz,
            OSSDatenItem::fromResponse($response->OSS_Daten->OSSDatenItem),
        );
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getBetragBruttoFw(): string
    {
        return $this->betragBruttoFw;
    }

    public function setBetragBruttoFw(string $betragBruttoFw): void
    {
        $this->betragBruttoFw = $betragBruttoFw;
    }

    public function getBetragNettoFw(): string
    {
        return $this->betragNettoFw;
    }

    public function setBetragNettoFw(string $betragNettoFw): void
    {
        $this->betragNettoFw = $betragNettoFw;
    }

    public function getErtragsKonto(): int
    {
        return $this->ertragsKonto;
    }

    public function setErtragsKonto(int $ertragsKonto): void
    {
        $this->ertragsKonto = $ertragsKonto;
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

    public function getSteuersatz(): string
    {
        return $this->steuersatz;
    }

    public function setSteuersatz(string $steuersatz): void
    {
        $this->steuersatz = $steuersatz;
    }

    public function getOssDatenItem(): OSSDatenItem
    {
        return $this->ossDatenItem;
    }

    public function setOssDatenItem(OSSDatenItem $ossDatenItem): void
    {
        $this->ossDatenItem = $ossDatenItem;
    }

    public function __toArray(): array
    {
        return [
            'Text' => $this->getText(),
            'BetragBruttoFW' => $this->betragBruttoFw,
            'BetragNettoFW' => $this->betragNettoFw,
            'Ertragskonto' => $this->ertragsKonto,
            'Kostenstelle1' => $this->kostenstelle1,
            'Kostenstelle2' => $this->kostenstelle2,
            'Steuersatz' => $this->steuersatz,
            'OSS_Daten' => [
                'OSSDatenItem' => $this->getOssDatenItem()->toArray()
            ],
        ];
    }
}
