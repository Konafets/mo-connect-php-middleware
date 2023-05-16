<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen;

use ArrobaIt\MoConnectApi\Models\Enums\BuchungsStatusEnum;
use ArrobaIt\MoConnectApi\Models\Enums\FestschreibStatusEnum;
use stdClass;

class BuchungListItem
{
    protected string $buchungId = '';

    protected string $datum = '';

    protected string $text = '';

    protected BuchungsStatusEnum $status;

    protected string $summe = '';

    protected string $summeFw = '';

    protected string $belegNr = '';

    public function __construct(
        string $buchungId,
        string $datum,
        string $text,
        BuchungsStatusEnum $status,
        string $summe,
        string $summeFw,
        string $belegNr,
    ) {
        $this->buchungId = $buchungId;
        $this->datum = $datum;
        $this->text = $text;
        $this->status = $status;
        $this->summe = $summe;
        $this->summeFw = $summeFw;
        $this->belegNr = $belegNr;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Buchung_ID,
            $response->Datum,
            $response->Text,
            BuchungsStatusEnum::from((int) $response->Status),
            $response->Summe,
            $response->SummeFW,
            $response->BelegNr,
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

    public function __toArray(): array
    {
        return [
            'Buchung_ID' => $this->getBuchungId(),
            'Datum' => $this->getDatum(),
            'Text' => $this->getText(),
            'Status' => $this->getStatus(),
            'Summe' => $this->getSumme(),
            'SummeFW' => $this->getSummeFw(),
            'BelegNr' => $this->getBelegNr(),
        ];
    }
}
