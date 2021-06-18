<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class AnsprechpartnerListItem
{
    use ResponseTrait;

    protected string $adresseId = '';
    protected string $ansprechpartnerId = '';
    protected string $abteilung = '';
    protected string $position = '';
    protected string $vorname = '';
    protected string $nachname = '';
    protected string $emailFirma = '';
    protected string $emailPrivat = '';
    protected string $telefonFirma = '';
    protected string $telefonMobil = '';
    protected string $telefonPrivat = '';

    public function __construct(
        string $adresseId,
        string $ansprechpartnerId,
        string $abteilung,
        string $position,
        string $vorname,
        string $nachname,
        string $emailFirma,
        string $emailPrivat,
        string $telefonFirma,
        string $telefonMobil,
        string $telefonPrivat
    ) {
        $this->adresseId = $adresseId;
        $this->ansprechpartnerId = $ansprechpartnerId;
        $this->abteilung = $abteilung;
        $this->position = $position;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->emailFirma = $emailFirma;
        $this->emailPrivat = $emailPrivat;
        $this->telefonFirma = $telefonFirma;
        $this->telefonMobil = $telefonMobil;
        $this->telefonPrivat = $telefonPrivat;
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

    public function getAnsprechpartnerId(): string
    {
        return $this->ansprechpartnerId;
    }

    public function setAnsprechpartnerId(string $ansprechpartnerId): void
    {
        $this->ansprechpartnerId = $ansprechpartnerId;
    }

    public function getAbteilung(): string
    {
        return $this->abteilung;
    }

    public function setAbteilung(string $abteilung): void
    {
        $this->abteilung = $abteilung;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function setVorname(string $vorname): void
    {
        $this->vorname = $vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function setNachname(string $nachname): void
    {
        $this->nachname = $nachname;
    }

    public function getEmailFirma(): string
    {
        return $this->emailFirma;
    }

    public function setEmailFirma(string $emailFirma): void
    {
        $this->emailFirma = $emailFirma;
    }

    public function getEmailPrivat(): string
    {
        return $this->emailPrivat;
    }

    public function setEmailPrivat(string $emailPrivat): void
    {
        $this->emailPrivat = $emailPrivat;
    }

    public function getTelefonFirma(): string
    {
        return $this->telefonFirma;
    }

    public function setTelefonFirma(string $telefonFirma): void
    {
        $this->telefonFirma = $telefonFirma;
    }

    public function getTelefonMobil(): string
    {
        return $this->telefonMobil;
    }

    public function setTelefonMobil(string $telefonMobil): void
    {
        $this->telefonMobil = $telefonMobil;
    }

    public function getTelefonPrivat(): string
    {
        return $this->telefonPrivat;
    }

    public function setTelefonPrivat(string $telefonPrivat): void
    {
        $this->telefonPrivat = $telefonPrivat;
    }
}
