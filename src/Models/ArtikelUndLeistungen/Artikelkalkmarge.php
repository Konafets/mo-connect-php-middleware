<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\ArtikelUndLeistungen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class Artikelkalkmarge
{
    use ResponseTrait;

    protected const MARGE_ARTEN = [
        1 => 'Betrag',
        2 => 'Prozent',
        3 => 'VKGesamt',
    ];

    protected int $margeArt;

    public function __construct(int $margeArt)
    {
        $this->margeArt = $margeArt;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self($response->MargeArt);
    }

    public function getMargeArt(): int
    {
        return $this->margeArt;
    }

    public function setMargeArt(int $margeArt): void
    {
        $this->margeArt = $margeArt;
    }

    public function getMargeArtBeschreibung(): string
    {
        return isset(self::MARGE_ARTEN[$this->getMargeArt()]) ? self::MARGE_ARTEN[$this->getMargeArt()] : '';
    }
}
