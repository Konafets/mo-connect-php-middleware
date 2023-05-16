<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\Buchungen\Collections\BuchungJournalItemListCollection;
use ArrobaIt\MoConnectApi\Models\Enums\BuchungsStatusEnum;
use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use ArrobaIt\MoConnectApi\Models\Vorgaben\FestschreibStatus;
use stdClass;

class BuchungItem
{
    use ResponseTrait;

    protected string $buchungId = '';

    protected string $datum = '';

    protected string $text = '';

    protected BuchungsStatusEnum $status;

    protected string $summe = '';

    /**
     * Summe Fremdwährung
     *
     * @var string
     */
    protected string $summeFw = '';

    protected string $belegNr = '';

    protected string $eingabeDatum = '';

    protected string $referenz = '';

    protected string $notizen = '';

    protected int $kontoSoll = 0;

    protected int $kontoHaben = 0;

    protected string $waehrung = '';

    protected string $kurs = '';

    protected string $steuersatz = '';

    protected FestschreibStatusEnum $festschreibStatus;

    /**
     * @var BuchungJournalItemListCollection<BuchungJournalItem>
     */
    protected BuchungJournalItemListCollection $buchungJournalItemList;

    /**
     * @var array<string>
     */
    protected array $attachmentIdList;

    public function __construct(
        string $buchungId,
        string $datum,
        string $text,
        BuchungsStatusEnum $status,
        string $summe,
        string $summeFw,
        string $belegNr,
        string $eingabeDatum,
        string $referenz,
        string $notzien,
        int $kontoSoll,
        int $kontoHaben,
        string $waehrung,
        string $kurs,
        string $steuersatz,
        FestschreibStatusEnum $festschreibStatus,
        BuchungJournalItemListCollection $buchungJournalItemList,
        array $attachmentIdList
    ) {
        $this->buchungId = $buchungId;
        $this->datum = $datum;
        $this->text = $text;
        $this->status = $status;
        $this->summe = $summe;
        $this->summeFw = $summeFw;
        $this->belegNr = $belegNr;
        $this->eingabeDatum = $eingabeDatum;
        $this->referenz = $referenz;
        $this->notizen = $notzien;
        $this->kontoSoll = $kontoSoll;
        $this->kontoHaben = $kontoHaben;
        $this->waehrung = $waehrung;
        $this->kurs = $kurs;
        $this->steuersatz = $steuersatz;
        $this->festschreibStatus = $festschreibStatus;
        $this->buchungJournalItemList = $buchungJournalItemList;
        $this->attachmentIdList = $attachmentIdList;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Buchung_ID,
            $response->Datum,
            $response->Text,
            BuchungsStatusEnum::from($response->Status),
            $response->Summe,
            $response->SummeFW,
            $response->BelegNr,
            $response->EingabeDatum,
            $response->Referenz,
            $response->Notizen,
            $response->KontoSoll,
            $response->KontoHaben,
            $response->Waehrung,
            $response->Kurs,
            $response->Steuersatz,
            FestschreibStatusEnum::from((int) $response->FestschreibStatus),
            BuchungJournalItemListCollection::fromResponse($response->BuchungJournalItemList),
            $response->AttachmentIDList,
        );
    }

    public function getBuchungId(): string
    {
        return $this->buchungId;
    }

    public function setBuchungId(string $buchungId): void
    {
        $this->buchungId = $buchungId;
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

    public function getStatus(): int
    {
        return $this->status->value;
    }

    public function setStatus(BuchungsStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getSumme(): string
    {
        return $this->summe;
    }

    public function setSumme(string $summe): void
    {
        $this->summe = $summe;
    }

    public function getSummeFw(): string
    {
        return $this->summeFw;
    }

    public function setSummeFw(string $summeFw): void
    {
        $this->summeFw = $summeFw;
    }

    public function getBelegNr(): string
    {
        return $this->belegNr;
    }

    public function setBelegNr(string $belegNr): void
    {
        $this->belegNr = $belegNr;
    }

    public function getEingabeDatum(): string
    {
        return $this->eingabeDatum;
    }

    public function setEingabeDatum(string $eingabeDatum): void
    {
        $this->eingabeDatum = $eingabeDatum;
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

    public function getSteuersatz(): string
    {
        return $this->steuersatz;
    }

    public function setSteuersatz(string $steuersatz): void
    {
        $this->steuersatz = $steuersatz;
    }

    public function getFestschreibStatus(): int
    {
        return $this->festschreibStatus->value;
    }

    public function setFestschreibStatus(FestschreibStatusEnum $festschreibStatus): void
    {
        $this->festschreibStatus = $festschreibStatus;
    }

    public function getBuchungJournalItemList(): BuchungJournalItemListCollection
    {
        return $this->buchungJournalItemList;
    }

    public function setBuchungJournalItemList(BuchungJournalItemListCollection $buchungJournalItemList): void
    {
        $this->buchungJournalItemList = $buchungJournalItemList;
    }

    public function getAttachmentIdList(): array
    {
        return $this->attachmentIdList;
    }

    public function setAttachmentIdList(array $attachmentIdList): void
    {
        $this->attachmentIdList = $attachmentIdList;
    }
}
