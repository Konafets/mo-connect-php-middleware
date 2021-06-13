<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class DruckFormularListItem
{
    use ResponseTrait;

    protected string $druckFormularName = '';

    protected DruckFormularGruppen $druckFormularGruppe;

    public function __construct(string $druckFormularName, DruckFormularGruppen $druckFormularGruppe)
    {
        $this->druckFormularName = $druckFormularName;
        $this->druckFormularGruppe = $druckFormularGruppe;
    }

    public static function fromResponse(stdClass $druckFormularListItem): self
    {
        self::$content = $druckFormularListItem;

        $gruppe = new DruckFormularGruppen($druckFormularListItem->DruckformularGruppe);

        return new self(
            $druckFormularListItem->DruckformularName,
            $gruppe,
        );
    }

    public function getDruckFormularName(): string
    {
        return $this->druckFormularName;
    }

    public function setDruckFormularName(string $druckFormularName): void
    {
        $this->druckFormularName = $druckFormularName;
    }

    public function getDruckFormularGruppe(): DruckFormularGruppen
    {
        return $this->druckFormularGruppe;
    }

    public function setDruckFormularGruppe(DruckFormularGruppen $druckFormularGruppe): void
    {
        $this->druckFormularGruppe = $druckFormularGruppe;
    }
}
