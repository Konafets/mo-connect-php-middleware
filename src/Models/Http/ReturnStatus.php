<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Http;

use Illuminate\Support\Collection;
use stdClass;

class ReturnStatus
{
    protected Statuscode $statuscode;

    /**
     * @var \Illuminate\Support\Collection<StatustextItem>
     */
    protected Collection $statustextItems;

    protected string $insertId = '';

    public function __construct(Statuscode $statuscode, Collection $statustextItems, string $insertId = '')
    {
        $this->statuscode = $statuscode;
        $this->statustextItems = $statustextItems;
        $this->insertId = $insertId;
    }

    public static function fromResponse(stdClass $response): self
    {
        $statusTextItems = new Collection();

        if (isset($response->StatustextItem) && is_array($response->StatustextItem)) {
            foreach ($response->StatustextItem as $item) {
                $statusTextItems->add(StatustextItem::fromResponse($item));
            }
        }

        if (isset($response->Statustext)) {
            $statusTextItems->add(StatustextItem::fromResponse($response));
        }

        $insertId = $response->Insert_ID ?? '';

        return new self(
            new Statuscode($response->Statuscode),
            $statusTextItems,
            $insertId,
        );
    }

    public function getStatuscode(): int
    {
        return $this->statuscode->getStatusCode();
    }

    /**
     * @return Collection<StatustextItem>
     */
    public function getStatustextItems(): Collection
    {
        return $this->statustextItems;
    }

    public function getInsertId(): ?string
    {
        return $this->insertId;
    }

    public function hasInsertId(): bool
    {
        return $this->insertId !== '';
    }

    public function isOk(): bool
    {
        return $this->statuscode->isOk();
    }

    public function isCommonError(): bool
    {
        return $this->statuscode->isCommonError();
    }

    public function isAccessError(): bool
    {
        return $this->statuscode->isAccessError();
    }

    public function isFunctionUnknown(): bool
    {
        return $this->statuscode->isFunctionUnknown();
    }

    public function isParameterError(): bool
    {
        return $this->statuscode->isParameterError();
    }

    public function getStatusMessage(): string
    {
        $message = $this->getStatustextItems()->map(function(StatustextItem $item) {
            return $item->getStatusText();
        })->implode(' ');

        return $message;
    }
}
