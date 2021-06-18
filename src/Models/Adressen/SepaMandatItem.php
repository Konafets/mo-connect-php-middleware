<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use Carbon\Carbon;
use stdClass;

/**
 * Class SepaMandatItem
 *
 * @package ArrobaIt\MoConnectApi\Models\Adressen
 * @author Stefano Kowalke <info@arroba-it.de>
 * @since 17.0
 */
class SepaMandatItem
{
    use ResponseTrait;

    protected string $sepaMandatId = '';
    protected string $versionKey = '';
    protected string $adresseId = '';
    protected string $mandatReferenz = '';
    protected SepaMandatStatus $mandatStatus;
    protected SepaMandatArt $mandatArt;
    protected SepaMandatTyp $mandatTyp;
    protected int $einreichfrist;
    protected Carbon $gueltigAb;
    protected Carbon $gueltigBi;
    protected Carbon $aktiviertBis;
    protected Carbon $widerrufenAm;
    protected Carbon $letzteVerwendung;
    protected Carbon $erstelltAm;

    public function __construct(
        string $sepaMandatId,
        string $versionKey,
        string $adresseId,
        string $mandatReferenz,
        SepaMandatStatus $mandatStatus,
        SepaMandatArt $mandatArt,
        SepaMandatTyp $mandatTyp,
        int $einreichfrist,
        Carbon $gueltigAb,
        Carbon $gueltigBi,
        Carbon $aktiviertBis,
        Carbon $widerrufenAm,
        Carbon $letzteVerwendung,
        Carbon $erstelltAm
    ) {
        $this->sepaMandatId = $sepaMandatId;
        $this->versionKey = $versionKey;
        $this->adresseId = $adresseId;
        $this->mandatReferenz = $mandatReferenz;
        $this->mandatStatus = $mandatStatus;
        $this->mandatArt = $mandatArt;
        $this->mandatTyp = $mandatTyp;
        $this->einreichfrist = $einreichfrist;
        $this->gueltigAb = $gueltigAb;
        $this->gueltigBi = $gueltigBi;
        $this->aktiviertBis = $aktiviertBis;
        $this->widerrufenAm = $widerrufenAm;
        $this->letzteVerwendung = $letzteVerwendung;
        $this->erstelltAm = $erstelltAm;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

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

    public function getVersionKey(): string
    {
        return $this->versionKey;
    }

    public function setVersionKey(string $versionKey): void
    {
        $this->versionKey = $versionKey;
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

    public function getGueltigBi(): Carbon
    {
        return $this->gueltigBi;
    }

    public function setGueltigBi(Carbon $gueltigBi): void
    {
        $this->gueltigBi = $gueltigBi;
    }

    public function getAktiviertBis(): Carbon
    {
        return $this->aktiviertBis;
    }

    public function setAktiviertBis(Carbon $aktiviertBis): void
    {
        $this->aktiviertBis = $aktiviertBis;
    }

    public function getWiderrufenAm(): Carbon
    {
        return $this->widerrufenAm;
    }

    public function setWiderrufenAm(Carbon $widerrufenAm): void
    {
        $this->widerrufenAm = $widerrufenAm;
    }

    public function getLetzteVerwendung(): Carbon
    {
        return $this->letzteVerwendung;
    }

    public function setLetzteVerwendung(Carbon $letzteVerwendung): void
    {
        $this->letzteVerwendung = $letzteVerwendung;
    }

    public function getErstelltAm(): Carbon
    {
        return $this->erstelltAm;
    }

    public function setErstelltAm(Carbon $erstelltAm): void
    {
        $this->erstelltAm = $erstelltAm;
    }
}
