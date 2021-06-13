<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class DruckFormularFilter
{
    use ResponseTrait;

    protected string $suchtext = '';

    protected int $druckFormularGruppe;

    public function __construct(string $suchtext, int $druckFormularGruppe)
    {
        $this->suchtext = $suchtext;
        $this->druckFormularGruppe = $druckFormularGruppe;
    }

    public static function fromResponse(stdClass $druckFormularFilter): self
    {
        self::$content = $druckFormularFilter;

        return new self(
            $druckFormularFilter->Suchtext,
            (int)$druckFormularFilter->DruckformularGruppe,
        );
    }

    public function getSuchtext(): string
    {
        return $this->suchtext;
    }

    public function setSuchtext(string $suchtext): void
    {
        $this->suchtext = $suchtext;
    }

    public function getDruckFormularGruppe(): int
    {
        return $this->druckFormularGruppe;
    }

    public function setDruckFormularGruppe(int $druckFormularGruppe): void
    {
        $this->druckFormularGruppe = $druckFormularGruppe;
    }
}
