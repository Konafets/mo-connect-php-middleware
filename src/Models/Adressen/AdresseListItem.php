<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

class AdresseListItem
{
    protected string $adresseID = '';
    protected string $matchcode = '';
    protected string $adressNr = '';
    protected string $kategorie = '';
    protected AdresseStatus $kundenStatus;
    protected AdresseStatus $lieferantenStatus;

    /**
     * Rechnungsanschrift
     *
     * @var string
     */
    protected string $raFirma1 = '';
    protected string $raVorname = '';
    protected string $raNachname = '';
    protected string $raPlz = '';
    protected string $raOrt = '';

    /**
     * @var string
     * @since 18.0.0
     */
    protected string $raStrasse = '';

    /**
     * @var string
     * @since 18.0.0
     */
    protected string $raStrasseNr = '';

    public function __construct(
        string $adresseId,
        string $matchcode,
        string $adressNr,
        string $kategorie,
        AdresseStatus $kundenStatus,
        AdresseStatus $lieferantenStatus,
        string $raFirma1,
        string $raVorname,
        string $raNachname,
        string $raPlz,
        string $raOrt,
        string $raStrasse,
        string $raStrasseNr
    ) {
        $this->adresseID = $adresseId;
        $this->matchcode = $matchcode;
        $this->adressNr = $adressNr;
        $this->kategorie = $kategorie;
        $this->kundenStatus = $kundenStatus;
        $this->lieferantenStatus = $lieferantenStatus;
        $this->raFirma1 = $raFirma1;
        $this->raVorname = $raVorname;
        $this->raNachname = $raNachname;
        $this->raPlz = $raPlz;
        $this->raOrt = $raOrt;
        $this->raStrasse = $raStrasse;
        $this->raStrasseNr = $raStrasseNr;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Adresse_ID,
            $response->Matchcode,
            $response->AdressNr,
            $response->Kategorie,
            new AdresseStatus((int) $response->KundenStatus),
            new AdresseStatus((int) $response->LieferantenStatus),
            $response->RA_Firma1,
            $response->RA_Vorname,
            $response->RA_Nachname,
            $response->RA_Plz,
            $response->RA_Ort,
            $response->RA_Strasse,
            $response->RA_StrasseNr,
        );
    }

    public function getAdresseID(): string
    {
        return $this->adresseID;
    }

    public function setAdresseID(string $adresseID): void
    {
        $this->adresseID = $adresseID;
    }

    public function getMatchcode(): string
    {
        return $this->matchcode;
    }

    public function setMatchcode(string $matchcode): void
    {
        $this->matchcode = $matchcode;
    }

    public function getAdressNr(): string
    {
        return $this->adressNr;
    }

    public function setAdressNr(string $adressNr): void
    {
        $this->adressNr = $adressNr;
    }

    public function getKategorie(): string
    {
        return $this->kategorie;
    }

    public function setKategorie(string $kategorie): void
    {
        $this->kategorie = $kategorie;
    }

    public function getKundenStatus(): int
    {
        return $this->kundenStatus->getStatus();
    }

    public function getKundenStatusBeschreibung(): string
    {
        return (string) $this->kundenStatus;
    }

    public function setKundenStatus(int $kundenStatus): void
    {
        $this->kundenStatus->setStatus($kundenStatus);
    }

    public function getLieferantenStatus(): int
    {
        return $this->lieferantenStatus->getStatus();
    }

    public function getLieferantenStatusBeschreibung(): string
    {
        return (string) $this->lieferantenStatus;
    }

    public function setLieferantenStatus(int $lieferantenStatus): void
    {
        $this->lieferantenStatus->setStatus($lieferantenStatus);
    }

    public function getRaFirma1(): string
    {
        return $this->raFirma1;
    }

    public function setRaFirma1(string $raFirma1): void
    {
        $this->raFirma1 = $raFirma1;
    }

    public function getRaVorname(): string
    {
        return $this->raVorname;
    }

    public function setRaVorname(string $raVorname): void
    {
        $this->raVorname = $raVorname;
    }

    public function getRaNachname(): string
    {
        return $this->raNachname;
    }

    public function setRaNachname(string $raNachname): void
    {
        $this->raNachname = $raNachname;
    }

    public function getRaPlz(): string
    {
        return $this->raPlz;
    }

    public function setRaPlz(string $raPlz): void
    {
        $this->raPlz = $raPlz;
    }

    public function getRaOrt(): string
    {
        return $this->raOrt;
    }

    public function setRaOrt(string $raOrt): void
    {
        $this->raOrt = $raOrt;
    }

    public function getRaStrasse(): string
    {
        return $this->raStrasse;
    }

    public function setRaStrasse(string $raStrasse): void
    {
        $this->raStrasse = $raStrasse;
    }

    public function getRaStrasseNr(): string
    {
        return $this->raStrasseNr;
    }

    public function setRaStrasseNr(string $raStrasseNr): void
    {
        $this->raStrasseNr = $raStrasseNr;
    }
}
