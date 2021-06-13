<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\ArtikelUndLeistungen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class Artikelkalkbasis
{
    use ResponseTrait;

    public const BERECHNUNGS_ARTEN = [
        1 => 'Netto',
        2 => 'Brutto',
    ];

    protected int $berechnungsArt;

    public function __construct(int $berechnungsArt)
    {
        $this->berechnungsArt = $berechnungsArt;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self($response->BerechnungArt);
    }

    public function getBerechnungsArt(): int
    {
        return $this->berechnungsArt;
    }

    public function setBerechnungsArt(int $berechnungsArt): void
    {
        $this->berechnungsArt = $berechnungsArt;
    }

    public function getBerechnungArtBeschreibung(): string
    {
        return isset(self::BERECHNUNGS_ARTEN[$this->berechnungsArt]) ? self::BERECHNUNGS_ARTEN[$this->berechnungsArt] : '';
    }
}
