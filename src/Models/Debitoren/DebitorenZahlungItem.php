<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Debitoren\Collections\DebitorenRechnungPositionItemListCollection;
use ArrobaIt\MoConnectApi\Models\Enums\DebitorenRechnungArtEnum;
use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use ArrobaIt\MoConnectApi\Models\Enums\ZahlungsartEnum;
use ArrobaIt\MoConnectApi\Models\Vorgaben\Zahlungsart;
use stdClass;

class DebitorenZahlungItem
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
    protected ZahlungsartEnum $zahlungsart;
    protected int $dKonto = 0;
    protected string $zahlungSw = '';
    protected string $minderungSw = '';

    protected string $text;
    protected string $waehrung;

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
        ZahlungsartEnum $zahlungsart = ZahlungsartEnum::UEBERWEISUNG,
        int $dKonto = 0,
        string $zahlungSw = '',
        string $minderungSw = '',
        string $text = '',
        string $waehrung = '',
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
        $this->zahlungsart = $zahlungsart;
        $this->dKonto = $dKonto;
        $this->zahlungSw = $zahlungSw;
        $this->minderungSw = $minderungSw;
        $this->text = $text;
        $this->waehrung = $waehrung;
    }

    public static function fromResponse(stdClass $response): self
    {
        $dKonto = 'D-Konto';

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
            ZahlungsartEnum::from($response->Zahlungsart),
            $response->{$dKonto},
            $response->ZahlungSW,
            $response->MinderungSW,
            $response->Text,
            $response->Waehrung,
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

    public function getKonto(): string
    {
        return $this->konto;
    }

    public function setKonto(string $konto): void
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

    public function getZahlungsart(): ZahlungsartEnum
    {
        return $this->zahlungsart;
    }

    public function setZahlungsart(ZahlungsartEnum $zahlungsart): void
    {
        $this->zahlungsart = $zahlungsart;
    }

    public function getDKonto(): string
    {
        return $this->dKonto;
    }

    public function setDKonto(string $dKonto): void
    {
        $this->dKonto = $dKonto;
    }

    public function getZahlungSw(): string
    {
        return $this->zahlungSw;
    }

    public function setZahlungSw(string $zahlungSw): void
    {
        $this->zahlungSw = $zahlungSw;
    }

    public function getMinderungSw(): string
    {
        return $this->minderungSw;
    }

    public function setMinderungSw(string $minderungSw): void
    {
        $this->minderungSw = $minderungSw;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getWaehrung(): string
    {
        return $this->waehrung;
    }

    public function setWaehrung(string $waehrung): void
    {
        $this->waehrung = $waehrung;
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
            'Zahlungsart' => $this->getZahlungsart(),
            'D-Konto' => $this->getDKonto(),
            'ZahlungSW' => $this->getZahlungSw(),
            'MinderungSW' => $this->getMinderungSw(),
            'Text' => $this->getText(),
            'Waehrung' => $this->getWaehrung(),
        ];
    }
}
