<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

/**
 * Class SepaMandatTyp
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatTyp
{
    use ResponseTrait;

    protected array $types = [
        1 => 'Einmalig',
        2 => 'Wiederholung',
    ];

    protected int $type;

    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }
}
