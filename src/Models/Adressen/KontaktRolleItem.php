<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class KontaktRolleItem
{
    use ResponseTrait;

    protected int $kontaktRolle;

    public function __construct(int $kontaktRolle)
    {
        $this->kontaktRolle = $kontaktRolle;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
    }

    public function getKontaktRolle(): int
    {
        return $this->kontaktRolle;
    }

    public function setKontaktRolle(int $kontaktRolle): void
    {
        $this->kontaktRolle = $kontaktRolle;
    }
}
