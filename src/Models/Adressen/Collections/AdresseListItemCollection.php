<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseListItem;
use ArrobaIt\MoConnectApi\Models\Collection;

class AdresseListItemCollection extends Collection
{
    /**
     * @var AdresseListItem[]
     */
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            AdresseListItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?AdresseListItem
    {
        return parent::offsetGet($offset);
    }
}
