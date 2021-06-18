<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use Carbon\Carbon;
use stdClass;

/**
 * Class SepaMandatAddItem
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatAddItem
{
    use ResponseTrait;

    protected string $adresseId = '';
    protected string $mandatReferenz = '';
    protected SepaMandatArt $mandatArt;
    protected SepaMandatTyp $mandatTyp;
    protected SepaMandatStatus $mandatStatus;
    protected int $einreichfrist;
    protected Carbon $gueltigAb;
    protected Carbon $gueltigBis;
    protected Carbon $aktiviertBis;

    public function __construct(
        string $adresseId,
        string $mandatReferenz,
        SepaMandatArt $mandatArt,
        SepaMandatTyp $mandatTyp,
        SepaMandatStatus $mandatStatus,
        int $einreichfrist,
        Carbon $gueltigAb,
        Carbon $gueltigBis,
        Carbon $aktiviertBis
    ) {
        $this->adresseId = $adresseId;
        $this->mandatReferenz = $mandatReferenz;
        $this->mandatArt = $mandatArt;
        $this->mandatTyp = $mandatTyp;
        $this->mandatStatus = $mandatStatus;
        $this->einreichfrist = $einreichfrist;
        $this->gueltigAb = $gueltigAb;
        $this->gueltigBis = $gueltigBis;
        $this->aktiviertBis = $aktiviertBis;
    }


    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
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

    public function getMandatStatus(): SepaMandatStatus
    {
        return $this->mandatStatus;
    }

    public function setMandatStatus(SepaMandatStatus $mandatStatus): void
    {
        $this->mandatStatus = $mandatStatus;
    }

    public function getEinreichfrist(): int
    {
        return $this->einreichfrist;
    }

    public function setEinreichfrist(int $einreichfrist): void
    {
        $this->einreichfrist = $einreichfrist;
    }

    public function getGueltigAb(): Carbon
    {
        return $this->gueltigAb;
    }

    public function setGueltigAb(Carbon $gueltigAb): void
    {
        $this->gueltigAb = $gueltigAb;
    }

    public function getGueltigBis(): Carbon
    {
        return $this->gueltigBis;
    }

    public function setGueltigBis(Carbon $gueltigBis): void
    {
        $this->gueltigBis = $gueltigBis;
    }

    public function getAktiviertBis(): Carbon
    {
        return $this->aktiviertBis;
    }

    public function setAktiviertBis(Carbon $aktiviertBis): void
    {
        $this->aktiviertBis = $aktiviertBis;
    }
}
