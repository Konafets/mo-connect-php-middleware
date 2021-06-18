<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

/**
 * Class SepaMandatListItem
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatListItem
{
    protected string $sepaMandatId = '';
    protected string $adresseId = '';
    protected string $mandatReferenz = '';
    protected SepaMandatStatus $mandatStatus;
    protected SepaMandatArt $mandatArt;
    protected SepaMandatTyp $mandatTyp;

    public function __construct(
        string $sepaMandatId,
        string $adresseId,
        string $mandatReferenz,
        SepaMandatStatus $mandatStatus,
        SepaMandatArt $mandatArt,
        SepaMandatTyp $mandatTyp
    ) {
        $this->sepaMandatId = $sepaMandatId;
        $this->adresseId = $adresseId;
        $this->mandatReferenz = $mandatReferenz;
        $this->mandatStatus = $mandatStatus;
        $this->mandatArt = $mandatArt;
        $this->mandatTyp = $mandatTyp;
    }


    public static function fromResponse(stdClass $response): self
    {
        return new self();
    }

    public function getSepaMandatId(): string
    {
        return $this->sepaMandatId;
    }

    public function setSepaMandatId(string $sepaMandatId): void
    {
        $this->sepaMandatId = $sepaMandatId;
    }

    public function getAdresseId(): string
    {
        return $this->adresseId;
    }

    public function setAdresseId(string $adresseId): void
    {
        $this->adresseId = $adresseId;
    }

    public function getMandatReferenz(): string
    {
        return $this->mandatReferenz;
    }

    public function setMandatReferenz(string $mandatReferenz): void
    {
        $this->mandatReferenz = $mandatReferenz;
    }

    public function getMandatStatus(): SepaMandatStatus
    {
        return $this->mandatStatus;
    }

    public function setMandatStatus(SepaMandatStatus $mandatStatus): void
    {
        $this->mandatStatus = $mandatStatus;
    }

    public function getMandatArt(): SepaMandatArt
    {
        return $this->mandatArt;
    }

    public function setMandatArt(SepaMandatArt $mandatArt): void
    {
        $this->mandatArt = $mandatArt;
    }

    public function getMandatTyp(): SepaMandatTyp
    {
        return $this->mandatTyp;
    }

    public function setMandatTyp(SepaMandatTyp $mandatTyp): void
    {
        $this->mandatTyp = $mandatTyp;
    }
}
