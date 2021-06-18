<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\AnsprechpartnerListItem;
use Illuminate\Support\Collection;

class AnsprechpartnerListItems extends Collection
{
    /**
     * @var AnsprechpartnerListItem[]
     */
    protected $items = [];


    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            AnsprechpartnerListItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?AnsprechpartnerListItem
    {
        return parent::offsetGet($offset);
    }
}
