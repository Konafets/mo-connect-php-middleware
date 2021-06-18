<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseKategorieItem;
use Illuminate\Support\Collection;

class AdresseKategorieItems extends Collection
{
    /**
     * @var AdresseKategorieItem[]
     */
    protected $items = [];


    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            AdresseKategorieItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?AdresseKategorieItem
    {
        return parent::offsetGet($offset);
    }
}
