<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\Buchungen\Collections\BuchungPositionItemListCollection;
use stdClass;

class BuchungAddItem
{
    protected string $datum = '';

    protected string $text = '';

    protected string $belegNr = '';

    protected string $referenz = '';

    protected string $notizen = '';

    protected string $waehrung = '';

    protected string $kurs = '1,00000000';

    protected BuchungPositionItemListCollection $buchungPositionItemList;

    public function __construct(
        string $datum,
        string $text,
        string $belegNr,
        string $referenz,
        string $notizen,
        string $waehrung,
        string $kurs,
        BuchungPositionItemListCollection $buchungPositionItemList
    ) {
        $this->datum = $datum;
        $this->text = $text;
        $this->belegNr = $belegNr;
        $this->referenz = $referenz;
        $this->notizen = $notizen;
        $this->waehrung = $waehrung;
        $this->kurs = $kurs;
        $this->buchungPositionItemList = $buchungPositionItemList;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Datum,
            $response->Text,
            $response->BelegNr,
            $response->Referenz,
            $response->Notizen,
            $response->Waehrung,
            $response->Kurs,
            BuchungPositionItemListCollection::fromResponse($response->BuchungPositionItemList),
        );
    }

    public function getDatum(): string
    {
        return $this->datum;
    }

    public function setDatum(string $datum): void
    {
        $this->datum = $datum;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getBelegNr(): string
    {
        return $this->belegNr;
    }

    public function setBelegNr(string $belegNr): void
    {
        $this->belegNr = $belegNr;
    }

    public function getReferenz(): string
    {
        return $this->referenz;
    }

    public function setReferenz(string $referenz): void
    {
        $this->referenz = $referenz;
    }

    public function getNotizen(): string
    {
        return $this->notizen;
    }

    public function setNotizen(string $notizen): void
    {
        $this->notizen = $notizen;
    }

    public function getWaehrung(): string
    {
        return $this->waehrung;
    }

    public function setWaehrung(string $waehrung): void
    {
        $this->waehrung = $waehrung;
    }

    public function getKurs(): string
    {
        return $this->kurs;
    }

    public function setKurs(string $kurs): void
    {
        $this->kurs = $kurs;
    }

    public function getBuchungPositionItemList(): BuchungPositionItemListCollection
    {
        return $this->buchungPositionItemList;
    }

    public function setBuchungPositionItemList(BuchungPositionItemListCollection $buchungPositionItemList): void
    {
        $this->buchungPositionItemList = $buchungPositionItemList;
    }

    public function __toArray(): array
    {
        return [
            'Datum' => $this->getDatum(),
            'Text' => $this->getText(),
            'BelegNr' => $this->getBelegNr(),
            'Referenz' => $this->getReferenz(),
            'Notizen' => $this->getNotizen(),
            'Waehrung' => $this->getWaehrung(),
            'Kurs' => $this->getKurs(),
            'BuchungPositionItemList' => [
                'BuchungPositionAddItem' => $this->getBuchungPositionItemList()->map(static function (BuchungPositionAddItem $item) {
                    return $item->toArray();
                })->toArray()
            ],
        ];
    }
}
