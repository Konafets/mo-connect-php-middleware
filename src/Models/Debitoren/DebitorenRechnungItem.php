<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren;

use ArrobaIt\MoConnectApi\Models\Debitoren\Collections\DebitorenRechnungPositionItemListCollection;
use ArrobaIt\MoConnectApi\Models\Enums\DebitorenRechnungArtEnum;
use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use ArrobaIt\MoConnectApi\Models\Enums\ZahlungsartEnum;
use ArrobaIt\MoConnectApi\Models\Vorgaben\Zahlungsart;
use stdClass;

class DebitorenRechnungItem
{
    protected string $postenId = '';
    protected string $adresseId = '';
    protected DebitorenRechnungArtEnum $rechnungArt;
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
    protected bool $entwurf;
    protected string $zahlungsbedingung = '';
    protected ZahlungsartEnum $zahlungsart;
    protected int $tageNetto;
    protected int $tageSkonto;
    protected float $prozentSkonto;
    protected bool $nichtMahnen;
    protected FestschreibStatusEnum $festschreibStatus;
    protected string $waehrung;
    protected string $text;

    /** @var array<string> */
    protected array $attachmentIdList = [];

    /** @var DebitorenRechnungPositionItemListCollection<DebitorenRechnungPositionItem>  */
    protected DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionList;

    public function __construct(
        string $postenId = '',
        string $adresseId = '',
        DebitorenRechnungArtEnum $rechnungArt = DebitorenRechnungArtEnum::DEBITOR_RECHNUNG,
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
        bool $entwurf = false,
        string $zahlungsbedingung = '',
        ZahlungsartEnum $zahlungsart = ZahlungsartEnum::UEBERWEISUNG,
        int $tageNetto = 0,
        int $tageSkonto = 0,
        float $prozentSkonto = 0.0,
        bool $nichtMahnen = true,
        FestschreibStatusEnum $festschreibStatus = FestschreibStatusEnum::ALLE,
        string $waehrung = '',
        string $text = '',
        array $attachmentIdList = [],
        DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionList,
    ) {
        $this->postenId = $postenId;
        $this->adresseId = $adresseId;
        $this->rechnungArt = $rechnungArt;
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
        $this->entwurf = $entwurf;
        $this->zahlungsbedingung = $zahlungsbedingung;
        $this->zahlungsart = $zahlungsart;
        $this->tageNetto = $tageNetto;
        $this->tageSkonto = $tageSkonto;
        $this->prozentSkonto = $prozentSkonto;
        $this->nichtMahnen = $nichtMahnen;
        $this->festschreibStatus = $festschreibStatus;
        $this->waehrung = $waehrung;
        $this->text = $text;
        $this->attachmentIdList = $attachmentIdList;
        $this->debitorenRechnungPositionList = $debitorenRechnungPositionList;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Posten_ID,
            $response->Adresse_ID,
            DebitorenRechnungArtEnum::from($response->RechnungArt),
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
            $response->Entwurf,
            $response->Zahlungsbedingung,
            ZahlungsartEnum::from($response->Zahlungsart),
            $response->TageNetto,
            $response->TageSkonto,
            $response->ProzentSkonto,
            $response->NichtMahnen,
            $response->FestschreibStatus,
            $response->Waehrung,
            $response->Text,
            $response->AttachmentIDList,
            $response->DebitorenRechnungPositionItemList,
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

    public function getRechnungArt(): DebitorenRechnungArtEnum
    {
        return $this->rechnungArt;
    }

    public function setRechnungArt(DebitorenRechnungArtEnum $rechnungArt): void
    {
        $this->rechnungArt = $rechnungArt;
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

    public function isEntwurf(): bool
    {
        return $this->entwurf;
    }

    public function setEntwurf(bool $entwurf): void
    {
        $this->entwurf = $entwurf;
    }

    public function getZahlungsbedingung(): string
    {
        return $this->zahlungsbedingung;
    }

    public function setZahlungsbedingung(string $zahlungsbedingung): void
    {
        $this->zahlungsbedingung = $zahlungsbedingung;
    }

    public function getZahlungsart(): ZahlungsartEnum
    {
        return $this->zahlungsart;
    }

    public function setZahlungsart(ZahlungsartEnum $zahlungsart): void
    {
        $this->zahlungsart = $zahlungsart;
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

    public function getFestschreibStatus(): FestschreibStatusEnum
    {
        return $this->festschreibStatus;
    }

    public function setFestschreibStatus(FestschreibStatusEnum $festschreibStatus): void
    {
        $this->festschreibStatus = $festschreibStatus;
    }

    public function getWaehrung(): string
    {
        return $this->waehrung;
    }

    public function setWaehrung(string $waehrung): void
    {
        $this->waehrung = $waehrung;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getAttachmentIdList(): array
    {
        return $this->attachmentIdList;
    }

    public function setAttachmentIdList(array $attachmentIdList): void
    {
        $this->attachmentIdList = $attachmentIdList;
    }

    public function getDebitorenRechnungPositionList(): DebitorenRechnungPositionItemListCollection
    {
        return $this->debitorenRechnungPositionList;
    }

    public function setDebitorenRechnungPositionList(
        DebitorenRechnungPositionItemListCollection $debitorenRechnungPositionList
    ): void {
        $this->debitorenRechnungPositionList = $debitorenRechnungPositionList;
    }

    public function __toArray(): array
    {
        return [
            'Posten_ID' => $this->getPostenId(),
            'Adresse_ID' => $this->getAdresseId(),
            'RechnungArt' => $this->getRechnungArt(),
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
            'Entwurf' => $this->isEntwurf(),
            'Zahlungsbedingung' => $this->getZahlungsbedingung(),
            'Zahlungsart' => $this->getZahlungsart(),
            'TageNetto' => $this->getTageNetto(),
            'TageSkonto' => $this->getTageSkonto(),
            'ProzentSkonto' => $this->getProzentSkonto(),
            'NichtMahnen' => $this->isNichtMahnen(),
            'FestschreibStatus' => $this->getFestschreibStatus(),
            'Waehrung' => $this->getWaehrung(),
            'Text' => $this->getText(),
            'AttachmentIDList' => $this->getAttachmentIdList(),
            'DebitorenRechnungPositionItemList' => $this->getDebitorenRechnungPositionList(),
        ];
    }
}
