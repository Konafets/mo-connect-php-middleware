<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

trait ResponseTrait
{
    protected static \stdClass $content;

    public function hasContent(): bool
    {
        return isset(self::$content) && self::$content !== null && self::$content instanceof \stdClass;
    }

    public function getContent(): \stdClass
    {
        return self::$content;
    }

    public function setContent(\stdClass $content): void
    {
        self::$content = $content;
    }

    public function hasStatus(): bool
    {
        return ($this->hasContent() && isset($this->getContent()->ReturnStatus));
    }

    public function getStatusCode(): int
    {
        if ($this->hasStatus()) {
            return $this->getContent()->ReturnStatus->StatusCode;
        }

        return 0;
    }

    public function isStatusOk(): bool
    {
        return ($this->hasStatus() && $this->getStatusCode() === 0);
    }
}
