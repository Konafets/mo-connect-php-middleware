<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

class KontaktRolleItem
{
    protected int $kontaktRolle;

    public function __construct(int $kontaktRolle)
    {
        $this->kontaktRolle = $kontaktRolle;
    }

    public static function fromResponse(stdClass $response): self
    {
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
