<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularListItem;

class DruckFormularListItemCollection extends Collection
{
    /**
     * @var DruckFormularListItem[]
     */
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $druckFormularListItems): self
    {
        $items = array_map(static fn($item) =>
            DruckFormularListItem::fromResponse($item),
            $druckFormularListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?DruckFormularListItem
    {
        return parent::offsetGet($offset);
    }
}
