<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

use ArrobaIt\MoConnectApi\Models\Http\Statuscode;
use Illuminate\Support\Collection;
use stdClass;

class ReturnStatus
{
    use ResponseTrait;

    protected Statuscode $statuscode;

    /**
     * @var \Illuminate\Support\Collection|null|StatustextItem[]
     */
    protected ?Collection $statustextItems;

    protected ?string $insertId = '';

    public function __construct(Statuscode $statuscode, Collection $statustextItem = null, string $insertId = null)
    {
        $this->statuscode = $statuscode;
        $this->statustextItems = $statustextItem;
        $this->insertId = $insertId;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;
        $statusTextItems = new Collection();

        if (isset($response->StatustextItem) && is_array($response->StatustextItem)) {
            $statusTextItems = new Collection($response->StatustextItem);
        }

        if (isset($response->Statustext) && is_string($response->Statustext)) {
            $statusTextItems = new Collection($response->Statustext);
        }

        return new self(
            new Statuscode($response->Statuscode),
            $statusTextItems,
            $response->Insert_ID,
        );
    }

    public function getStatuscode(): Statuscode
    {
        return $this->statuscode;
    }

    public function setStatuscode(Statuscode $statuscode): void
    {
        $this->statuscode = $statuscode;
    }

    public function getStatustextItems()
    {
        return $this->statustextItems;
    }

    public function setStatustextItems($statustextItems): void
    {
        $this->statustextItems = $statustextItems;
    }

    public function getInsertId(): ?string
    {
        return $this->insertId;
    }

    public function setInsertId(?string $insertId): void
    {
        $this->insertId = $insertId;
    }
}
