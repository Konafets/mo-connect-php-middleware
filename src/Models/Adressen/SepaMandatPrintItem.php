<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

/**
 * Class SepaMandatPrintItem
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 */
class SepaMandatPrintItem
{
    protected string $name = '';
    protected int $dateigroesse;
    protected string $dateityp = '';
    protected string $datenBASE64 = '';

    public function __construct(string $name, int $dateigroesse, string $dateityp, string $datenBASE64)
    {
        $this->name = $name;
        $this->dateigroesse = $dateigroesse;
        $this->dateityp = $dateityp;
        $this->datenBASE64 = $datenBASE64;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDateigroesse(): int
    {
        return $this->dateigroesse;
    }

    public function setDateigroesse(int $dateigroesse): void
    {
        $this->dateigroesse = $dateigroesse;
    }

    public function getDateityp(): string
    {
        return $this->dateityp;
    }

    public function setDateityp(string $dateityp): void
    {
        $this->dateityp = $dateityp;
    }

    public function getDatenBASE64(): string
    {
        return $this->datenBASE64;
    }

    public function setDatenBASE64(string $datenBASE64): void
    {
        $this->datenBASE64 = $datenBASE64;
    }
}
