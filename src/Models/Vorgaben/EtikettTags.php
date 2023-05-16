<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class EtikettTags
{
    use ResponseTrait;

    protected array $tags = [
        0 => 'Kein EtikettTag',
        1 => 'EtikettTag 1',
        2 => 'EtikettTag 2',
        4 => 'EtikettTag 3',
        8 => 'EtikettTag 4',
        16 => 'EtikettTag 5',
        32 => 'EtikettTag 6',
        64 => 'EtikettTag 7',
    ];

    protected int $tag;

    public function __construct(int $tag)
    {
        $this->tag = $tag;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
    }

    public function getTag(): int
    {
        return $this->tag;
    }

    public function setTag(int $tag): void
    {
        $this->tag = $tag;
    }
}
