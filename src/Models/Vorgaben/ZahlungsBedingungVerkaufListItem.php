<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class ZahlungsBedingungVerkaufListItem
{
    use ResponseTrait;

    protected string $bezeichnung = '';

    protected Zahlungsart $zahlungsart;

    protected int $tageNetto = 0;

    protected int $tageSkonto = 0;

    protected string $prozentSkonto = '';

    protected bool $nichtMahnen = false;

    public function __construct(
        string $bezeichnung,
        Zahlungsart $zahlungsart,
        int $tageNetto,
        int $tageSkonto,
        string $prozentSkonto,
        bool $nichtMahnen
    ) {
        $this->bezeichnung = $bezeichnung;
        $this->zahlungsart = $zahlungsart;
        $this->tageNetto = $tageNetto;
        $this->tageSkonto = $tageSkonto;
        $this->prozentSkonto = $prozentSkonto;
        $this->nichtMahnen = $nichtMahnen;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->Bezeichnung,
            Zahlungsart::fromResponse($response),
            $response->TageNetto,
            $response->TageSkonto,
            $response->ProzentSkonto,
            $response->NichtMahnen,
        );
    }

    public function getBezeichnung(): string
    {
        return $this->bezeichnung;
    }

    public function setBezeichnung(string $bezeichnung): void
    {
        $this->bezeichnung = $bezeichnung;
    }

    public function getZahlungsart(): int
    {
        return $this->zahlungsart->getArt();
    }


    public function getZahlungsartBeschreibung(): string
    {
        return $this->zahlungsart->getBechreibung();
    }

    public function setZahlungsart(int $zahlungsart): void
    {
        $this->zahlungsart->setArt($zahlungsart);
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

    public function getProzentSkonto(): string
    {
        return $this->prozentSkonto;
    }

    public function setProzentSkonto(string $prozentSkonto): void
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
}
