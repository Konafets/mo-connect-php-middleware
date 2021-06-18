<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

/**
 * Class SepaMandatArt
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatArt
{
    protected array $arten = [
        1 => 'Basislastschrift',
        2 => 'Firmenlastschrift',
    ];

    protected int $art;

    public function __construct(int $art)
    {
        $this->art = $art;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self();
    }

    public function getArt(): int
    {
        return $this->art;
    }

    public function setArt(int $art): void
    {
        $this->art = $art;
    }
}
