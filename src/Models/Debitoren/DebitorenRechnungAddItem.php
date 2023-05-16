<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Debitoren\Collections\DebitorenRechnungPositionItemListCollection;
use ArrobaIt\MoConnectApi\Models\Enums\DebitorenRechnungKalkbasisEnum;
use ArrobaIt\MoConnectApi\Models\Enums\ZahlungsartEnum;
use stdClass;

class DebitorenRechnungAddItem
{
    protected string $addressId = '';
    protected int $konto = 0;
    protected string $datum = '';
    protected string $belegNr = '';
    protected string $text = '';
    protected string $referenz = '';
    protected string $projectId = '';
    protected string $waehrung = '';
    protected DebitorenRechnungKalkbasisEnum $berechnungArt;
    protected string $zahlungsBedingung = '';
    protected ZahlungsartEnum $zahlungsArt;
    protected int $tageNetto;
    protected int $tageSkonto;
    protected float $prozentSkonto;
    protected bool $nichtMahnen;
    /** @var DebitorenRechnungPositionItemListCollection<DebitorenRechnungPositionAddItem> */
    protected DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionItemList;

    public function __construct(
        string $addressId,
        int $konto,
        string $datum,
        string $belegNr,
        string $text,
        string $referenz,
        string $projectId,
        string $waehrung,
        DebitorenRechnungKalkbasisEnum $berechnungArt,
        string $zahlungsBedingung,
        ZahlungsartEnum $zahlungsArt,
        int $tageNetto,
        int $tageSkonto,
        float $prozentSkonto,
        bool $nichtMahnen,
        DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionItemList
    ) {
        $this->addressId = $addressId;
        $this->konto = $konto;
        $this->datum = $datum;
        $this->belegNr = $belegNr;
        $this->text = $text;
        $this->referenz = $referenz;
        $this->projectId = $projectId;
        $this->waehrung = $waehrung;
        $this->berechnungArt = $berechnungArt;
        $this->zahlungsBedingung = $zahlungsBedingung;
        $this->zahlungsArt = $zahlungsArt;
        $this->tageNetto = $tageNetto;
        $this->tageSkonto = $tageSkonto;
        $this->prozentSkonto = $prozentSkonto;
        $this->nichtMahnen = $nichtMahnen;
        $this->debitorenRechnungPositionItemList = $debitorenRechnungPositionItemList;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Adresse_ID,
            (int) $response->Konto,
            $response->Datum,
            $response->BelegNr,
            $response->Text,
            $response->Referenz,
            $response->Projekt_ID,
            $response->Waehrung,
            DebitorenRechnungKalkbasisEnum::from((string) $response->BerechnungArt),
            $response->Zahlungsbedingung,
            ZahlungsartEnum::from((int) $response->Zahlungsart),
            (int) $response->TageNetto,
            (int) $response->TageSkonto,
            (float) $response->ProzentSkonto,
            $response->NichtMahnen,
            DebitorenRechnungPositionItemListCollection::fromResponse($response->DebitorenRechnungPositionItemList),
        );
    }

    public function getAddressId(): string
    {
        return $this->addressId;
    }

    public function setAddressId(string $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function getKonto(): int
    {
        return $this->konto;
    }

    public function setKonto(int $konto): void
    {
        $this->konto = $konto;
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

    public function getProjectId(): string
    {
        return $this->projectId;
    }

    public function setProjectId(string $projectId): void
    {
        $this->projectId = $projectId;
    }

    public function getWaehrung(): string
    {
        return $this->waehrung;
    }

    public function setWaehrung(string $waehrung): void
    {
        $this->waehrung = $waehrung;
    }

    public function getBerechnungArt(): string
    {
        return $this->berechnungArt->value;
    }

    public function setBerechnungArt(DebitorenRechnungKalkbasisEnum $berechnungArt): void
    {
        $this->berechnungArt = $berechnungArt;
    }

    public function getZahlungsBedingung(): string
    {
        return $this->zahlungsBedingung;
    }

    public function setZahlungsBedingung(string $zahlungsBedingung): void
    {
        $this->zahlungsBedingung = $zahlungsBedingung;
    }

    public function getZahlungsArt(): int
    {
        return $this->zahlungsArt->value;
    }

    public function setZahlungsArt(ZahlungsartEnum $zahlungsArt): void
    {
        $this->zahlungsArt = $zahlungsArt;
    }

    public function getTageNetto(): int
    {
        return $this->tageNetto;
    }

    public function setTageNetto(int $tageNetto): void
    {
        $this->tageNetto = $tageNetto;
    }

    public function getTageSkonto(): int
    {
        return $this->tageSkonto;
    }

    public function setTageSkonto(int $tageSkonto): void
    {
        $this->tageSkonto = $tageSkonto;
    }

    public function getProzentSkonto(): float
    {
        return $this->prozentSkonto;
    }

    public function setProzentSkonto(float $prozentSkonto): void
    {
        $this->prozentSkonto = $prozentSkonto;
    }

    public function isNichtMahnen(): bool
    {
        return $this->nichtMahnen;
    }

    public function setNichtMahnen(bool $nichtMahnen): void
    {
        $this->nichtMahnen = $nichtMahnen;
    }

    public function getDebitorenRechnungPositionItemList(): DebitorenRechnungPositionItemListCollection
    {
        return $this->debitorenRechnungPositionItemList;
    }

    public function setDebitorenRechnungPositionItemList(DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionItemList): void {
        $this->debitorenRechnungPositionItemList = $debitorenRechnungPositionItemList;
    }

    public function __toArray(): array
    {
        return [
            'Adresse_ID' => $this->addressId,
            'Konto' => $this->konto,
            'Datum' => $this->datum,
            'BelegNr' => $this->belegNr,
            'Text' => $this->text,
            'Referenz' => $this->referenz,
            'Projekt_ID' => $this->projectId,
            'Waehrung' => $this->waehrung,
            'BerechnungArt' => $this->getBerechnungArt(),
            'Zahlungsbedingung' => $this->zahlungsBedingung,
            'Zahlungsart' => $this->getZahlungsArt(),
            'TageNetto' => $this->tageNetto,
            'TageSkonto' => $this->tageSkonto,
            'ProzentSkonto' => $this->projectId,
            'NichtMahnen' => $this->nichtMahnen,
            'DebitorenRechnungPositionItemList' => [
                'DebitorenRechnungPositionAddItem' => $this->getDebitorenRechnungPositionItemList()->map(static function (DebitorenRechnungPositionAddItem $item) {
                    return $item->__toArray();
                })->toArray()
            ],
        ];
    }
}
