<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use Carbon\Carbon;
use stdClass;

class AnsprechpartnerAddItem
{
    protected string $adresseId = '';
    protected string $abteilung = '';
    protected string $position = '';
    protected string $vorname = '';
    protected string $nachname = '';
    protected string $emailFirma = '';
    protected string $emailPrivat = '';
    protected string $telefonFirma = '';
    protected string $telefonMobil = '';
    protected string $telefonPrivat = '';
    protected string $anrede = '';
    protected string $geschlecht = '';
    protected Carbon $geburtsdatum;
    protected string $briefanrede = '';
    protected string $zusatz = '';
    protected string $bemerkung = '';

    /**
     * @var KontaktRolleItem[]
     */
    protected array $kontaktRollenList;

    public function __construct(
        string $adresseId,
        string $abteilung,
        string $position,
        string $vorname,
        string $nachname,
        string $emailFirma,
        string $emailPrivat,
        string $telefonFirma,
        string $telefonMobil,
        string $telefonPrivat,
        string $anrede,
        string $geschlecht,
        Carbon $geburtsdatum,
        string $briefanrede,
        string $zusatz,
        string $bemerkung,
        array $kontaktRollenList
    ) {
        $this->adresseId = $adresseId;
        $this->abteilung = $abteilung;
        $this->position = $position;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->emailFirma = $emailFirma;
        $this->emailPrivat = $emailPrivat;
        $this->telefonFirma = $telefonFirma;
        $this->telefonMobil = $telefonMobil;
        $this->telefonPrivat = $telefonPrivat;
        $this->anrede = $anrede;
        $this->geschlecht = $geschlecht;
        $this->geburtsdatum = $geburtsdatum;
        $this->briefanrede = $briefanrede;
        $this->zusatz = $zusatz;
        $this->bemerkung = $bemerkung;
        $this->kontaktRollenList = $kontaktRollenList;
    }

    public static function fromResponse(stdClass $response): self
    {
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

    public function getAnrede(): string
    {
        return $this->anrede;
    }

    public function setAnrede(string $anrede): void
    {
        $this->anrede = $anrede;
    }

    public function getGeschlecht(): string
    {
        return $this->geschlecht;
    }

    public function setGeschlecht(string $geschlecht): void
    {
        $this->geschlecht = $geschlecht;
    }

    public function getGeburtsdatum(): Carbon
    {
        return $this->geburtsdatum;
    }

    public function setGeburtsdatum(Carbon $geburtsdatum): void
    {
        $this->geburtsdatum = $geburtsdatum;
    }

    public function getBriefanrede(): string
    {
        return $this->briefanrede;
    }

    public function setBriefanrede(string $briefanrede): void
    {
        $this->briefanrede = $briefanrede;
    }

    public function getZusatz(): string
    {
        return $this->zusatz;
    }

    public function setZusatz(string $zusatz): void
    {
        $this->zusatz = $zusatz;
    }

    public function getBemerkung(): string
    {
        return $this->bemerkung;
    }

    public function setBemerkung(string $bemerkung): void
    {
        $this->bemerkung = $bemerkung;
    }

    public function getKontaktRollenList(): array
    {
        return $this->kontaktRollenList;
    }

    public function setKontaktRollenList(array $kontaktRollenList): void
    {
        $this->kontaktRollenList = $kontaktRollenList;
    }
}
