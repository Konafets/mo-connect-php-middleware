<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Firmen;

use stdClass;

class FirmaListItems
{
    protected array $firmaListItems = [];

    public function __construct(array $firmaListItems)
    {
        $this->firmaListItems = $firmaListItems;
    }

    public static function fromResponse(stdClass $returnData): self
    {
        $firmaListItems = array_map(static fn($item) =>
            new FirmaListItem($item->Firma_ID, $item->Bezeichnung, $item->Zusatz),
            $returnData->FirmaListItem
        );

        return new self($firmaListItems);
    }

    public function getFirmaListItems(): array
    {
        return $this->firmaListItems;
    }

    public function setFirmaListItems(array $firmaListItems): void
    {
        $this->firmaListItems = $firmaListItems;
    }
}
