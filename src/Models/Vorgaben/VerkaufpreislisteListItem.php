<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ArtikelUndLeistungen\Artikelkalkbasis;
use ArrobaIt\MoConnectApi\Models\ArtikelUndLeistungen\Artikelkalkmarge;
use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class VerkaufpreislisteListItem
{
    use ResponseTrait;

    protected string $vkPreislisteId = '';

    protected string $bezeichnung = '';

    protected string $beschreibung = '';

    protected bool $standard = false;

    /**
     * Berechung des Artikels
     *
     * @var Artikelkalkbasis
     */
    protected Artikelkalkbasis $berechnungArt;

    /**
     * Marge des Artikels
     *
     * @var Artikelkalkmarge
     */
    protected Artikelkalkmarge $margeArt;

    public function __construct(
        string $vkPreislisteId,
        string $bezeichnung,
        string $beschreibung,
        bool $standard,
        Artikelkalkbasis $berechnungArt,
        Artikelkalkmarge $margeArt
    ) {
        $this->vkPreislisteId = $vkPreislisteId;
        $this->bezeichnung = $bezeichnung;
        $this->beschreibung = $beschreibung;
        $this->standard = $standard;
        $this->berechnungArt = $berechnungArt;
        $this->margeArt = $margeArt;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->VKPreisliste_ID,
            $response->Bezeichnung,
            $response->Beschreibung,
            $response->Standard,
            Artikelkalkbasis::fromResponse($response),
            Artikelkalkmarge::fromResponse($response),
        );
    }

    public function getVkPreislisteId(): string
    {
        return $this->vkPreislisteId;
    }

    public function setVkPreislisteId(string $vkPreislisteId): void
    {
        $this->vkPreislisteId = $vkPreislisteId;
    }

    public function getBezeichnung(): string
    {
        return $this->bezeichnung;
    }

    public function setBezeichnung(string $bezeichnung): void
    {
        $this->bezeichnung = $bezeichnung;
    }

    public function getBeschreibung(): string
    {
        return $this->beschreibung;
    }

    public function setBeschreibung(string $beschreibung): void
    {
        $this->beschreibung = $beschreibung;
    }

    public function isStandard(): bool
    {
        return $this->standard;
    }

    public function setStandard(bool $standard): void
    {
        $this->standard = $standard;
    }

    public function getBerechnungArt(): int
    {
        return $this->berechnungArt->getBerechnungsArt();
    }

    public function setBerechnungArt(int $berechnungArt): void
    {
        $this->berechnungArt->setBerechnungsArt($berechnungArt);
    }

    public function getBerechnungArtBeschreibung(): string
    {
        return $this->berechnungArt->getBerechnungArtBeschreibung();
    }

    public function getMargeArt(): int
    {
        return $this->margeArt->getMargeArt();
    }

    public function setMargeArt(int $margeArt): void
    {
        $this->margeArt->setMargeArt($margeArt);
    }

    public function getMargeArtBeschreibung(): string
    {
        return $this->margeArt->getMargeArtBeschreibung();
    }

}
