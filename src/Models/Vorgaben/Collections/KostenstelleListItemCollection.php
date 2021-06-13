<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;

class KostenstelleListItemCollection extends Collection
{
    /**
     * @var KostenstelleListItem[]
     */
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $kostenstelleListItems): self
    {
        $items = array_map(static fn($item) =>
            KostenstelleListItem::fromResponse($item),
            $kostenstelleListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?KostenstelleListItem
    {
        return parent::offsetGet($offset);
    }
}
