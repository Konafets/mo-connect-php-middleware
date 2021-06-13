<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class Zahlungsart
{
    use ResponseTrait;

    protected const METHODS = [
        0 => 'Keine',
        1 => 'Bar',
        2 => 'Lastschrift',
        3 => 'Kreditkarte',
        4 => 'Überweisung',
        5 => 'Scheck',
        6 => 'EC-Karte'
    ];

    protected int $art;

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->Zahlungsart,
        );
    }

    public function __construct(int $art)
    {
        $this->art = $art;
    }

    public function getArt(): int
    {
        return $this->art;
    }

    public function setArt(int $art): void
    {
        $this->art = $art;
    }

    public function getBechreibung(): string
    {
        return isset(self::METHODS[$this->getArt()]) ? self::METHODS[$this->getArt()] : '';
    }
}
