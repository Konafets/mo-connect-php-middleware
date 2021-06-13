<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularListItem;
use Iterator;

class DruckFormularListItemCollection implements ArrayAccess, Iterator
{
    protected int $position = 0;

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

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset): ?DruckFormularListItem
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
             $this->items[] = $value;
         } else {
             $this->items[$offset] = $value;
         }
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
