<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\SepaMandatListItem;
use Illuminate\Support\Collection;

class SepaMandatListItems extends Collection
{
    /**
     * @var SepaMandatListItem[]
     */
    protected $items = [];


    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            SepaMandatListItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?SepaMandatListItem
    {
        return parent::offsetGet($offset);
    }
}
