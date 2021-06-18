<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use ArrobaIt\MoConnectApi\Models\Vorgaben\Steuergebiet;
use stdClass;

class AdresseAddItem
{
    use ResponseTrait;

    protected string $matchCode = '';

    protected string $adressNummer = '';

    /**
     * Eine oder mehrere Kategorien, kommagtrennt
     *
     * @var string
     */
    protected string $kategorie = '';

    protected AdresseStatus $kundenStatus;

    protected AdresseStatus $lieferantenStatus;

    /**
     * Rechnungsanschrift | Firma 1
     *
     * @var string
     */
    protected string $raFirma1 = '';

    /**
     * Rechnungsanschrift | Firma 2
     *
     * @var string
     */
    protected string $raFirma2 = '';

    protected string $raAnrede = '';

    protected string $raZusatz = '';

    protected string $raVorname = '';

    protected string $raNachname = '';

    protected string $raPlz = '';

    protected string $raOrt = '';

    protected string $raGeschlecht = '';

    protected string $raStrasse = '';

    protected string $raStrasseNr = '';

    protected string $raLand = '';

    protected string $raLandISO = '';

    protected string $raPostfachPlz = '';

    protected string $raPostfachNr = '';

    protected bool $raPfVerwenden;

    protected string $raTelefon1 = '';

    protected string $raTelefon2 = '';

    protected string $raTelefon3 = '';

    protected string $raTelefax = '';

    protected string $raEmail = '';

    protected string $raInternet = '';

    /**
     * Lieferanschrift
     *
     * @var string
     */
    protected string $laFirma1 = '';

    protected string $laFirma2 = '';

    protected bool $laLaVerwenden;

    protected string $laAnrede = '';

    protected string $laVorname = '';

    protected string $laNachname = '';

    protected string $laZusatz = '';

    protected string $laStrasse = '';

    protected string $laStrasseNr = '';

    protected string $laPlz = '';

    protected string $laOrt = '';

    protected string $laLand = '';

    protected string $laPostfachPlz = '';

    protected string $laPostfachNr = '';

    protected bool $laPfVerwenden;

    protected string $laTelefon = '';

    protected string $laTelefax = '';

    protected string $laEmail = '';

    protected string $laLieferart = '';

    /**
     * Kunde Faktura
     * @var string
     */
    protected string $kfZahlungsbedingungen = '';

    protected AdressePreisAngabe $kfPreisangabe;

    protected string $kfExterneNr = '';

    protected bool $kfLieferstopp;

    protected string $kfRabatt = '';

    protected string $kfKoSt1 = '';

    protected string $kfKoSt2 = '';

    protected string $kfPreislisteID = '';

    protected int $kfErtragkonto;

    /**
     * Kunde Faktura
     * @var int
     */
    protected int $kfKonto;

    protected bool $kfSammelkonto;

    protected string $kfWaehrung = '';

    protected int $kfFinanzKonto;

    protected BankdatenItem $kfBankdaten;

    /**
     * Lieferant Faktura
     * @var string
     */
    protected string $lfZahlungsbedingungen = '';

    protected AdressePreisAngabe $lfPreisangabe;

    protected string $lfExterneNr = '';

    protected bool $lfBestellstopp;

    protected string $lfRabatt = '';

    protected string $lfKoSt1 = '';

    protected string $lfKoSt2 = '';

    protected int $lfAufwandkonto;

    protected int $lfKonto;

    protected bool $lfSammelkonto;

    protected string $lfWaehrung = '';

    protected int $lfFinanzKonto;

    protected BankdatenItem $lfBankdaten;

    protected Steuergebiet $steuergebiet;

    protected string $uStId = '';

    protected string $belegsprache = '';

    protected string $briefanrede = '';

    protected string $briefgruss = '';

    protected string $notizen = '';

    protected bool $mailPreferred;

    /**
     * @var string[]
     */
    protected array $attachmentIdList;

    public function __construct(
        string $matchCode,
        string $adressNummer = '',
        string $kategorie = '',
        ?AdresseStatus $kundenStatus = null,
        ?AdresseStatus $lieferantenStatus = null,
        string $raFirma1 = '',
        string $raFirma2 = '',
        string $raAnrede = '',
        string $raZusatz = '',
        string $raVorname = '',
        string $raNachname = '',
        string $raPlz = '',
        string $raOrt = '',
        string $raGeschlecht = '',
        string $raStrasse = '',
        string $raStrasseNr = '',
        string $raLand = '',
        string $raLandISO = '',
        string $raPostfachPlz = '',
        string $raPostfachNr = '',
        bool $raPfVerwenden = false,
        string $raTelefon1 = '',
        string $raTelefon2 = '',
        string $raTelefon3 = '',
        string $raTelefax = '',
        string $raEmail = '',
        string $raInternet = '',
        string $laFirma1 = '',
        string $laFirma2 = '',
        bool $laLaVerwenden = false,
        string $laAnrede = '',
        string $laVorname = '',
        string $laNachname = '',
        string $laZusatz = '',
        string $laStrasse = '',
        string $laStrasseNr = '',
        string $laPlz = '',
        string $laOrt = '',
        string $laLand = '',
        string $laPostfachPlz = '',
        string $laPostfachNr = '',
        bool $laPfVerwenden = false,
        string $laTelefon = '',
        string $laTelefax = '',
        string $laEmail = '',
        string $laLieferart = '',
        int $kfKonto = 0,
        bool $kfSammelkonto = false,
        string $kfZahlungsbedingungen = '',
        int $kfErtragkonto = 0,
        string $kfWaehrung = '',
        int $kfFinanzKonto = 0,
        AdressePreisAngabe $kfPreisangabe = null,
        string $kfKoSt1 = '',
        string $kfKoSt2 = '',
        string $kfExterneNr = '',
        bool $kfLieferstopp = false,
        string $kfRabatt = '',
        string $kfPreislisteID = '',
        BankdatenItem $kfBankdaten = null,
        int $lfKonto = 0,
        bool $lfSammelkonto = false,
        string $lfZahlungsbedingungen = '',
        int $lfAufwandkonto = 0,
        string $lfWaehrung = '',
        int $lfFinanzKonto = 0,
        AdressePreisAngabe $lfPreisangabe = null,
        string $lfKoSt1 = '',
        string $lfKoSt2 = '',
        string $lfExterneNr = '',
        bool $lfBestellstopp = false,
        string $lfRabatt = '',
        BankdatenItem $lfBankdaten = null,
        Steuergebiet $steuergebiet = null,
        string $uStId = '',
        string $belegsprache = '',
        string $briefanrede = '',
        string $briefgruss = '',
        string $notizen = '',
        bool $mailPreferred = false,
        array $attachmentIdList = []
    ) {
        $this->matchCode = $matchCode;
        $this->adressNummer = $adressNummer;
        $this->kategorie = $kategorie;
        $this->kundenStatus = $kundenStatus instanceof AdresseStatus ?: new AdresseStatus();
        $this->lieferantenStatus = $lieferantenStatus instanceof AdresseStatus ?: new AdresseStatus();
        $this->raFirma1 = $raFirma1;
        $this->raFirma2 = $raFirma2;
        $this->raAnrede = $raAnrede;
        $this->raZusatz = $raZusatz;
        $this->raVorname = $raVorname;
        $this->raNachname = $raNachname;
        $this->raPlz = $raPlz;
        $this->raOrt = $raOrt;
        $this->raGeschlecht = $raGeschlecht;
        $this->raStrasse = $raStrasse;
        $this->raStrasseNr = $raStrasseNr;
        $this->raLand = $raLand;
        $this->raLandISO = $raLandISO;
        $this->raPostfachPlz = $raPostfachPlz;
        $this->raPostfachNr = $raPostfachNr;
        $this->raPfVerwenden = $raPfVerwenden;
        $this->raTelefon1 = $raTelefon1;
        $this->raTelefon2 = $raTelefon2;
        $this->raTelefon3 = $raTelefon3;
        $this->raTelefax = $raTelefax;
        $this->raEmail = $raEmail;
        $this->raInternet = $raInternet;
        $this->laFirma1 = $laFirma1;
        $this->laFirma2 = $laFirma2;
        $this->laLaVerwenden = $laLaVerwenden;
        $this->laAnrede = $laAnrede;
        $this->laVorname = $laVorname;
        $this->laNachname = $laNachname;
        $this->laZusatz = $laZusatz;
        $this->laStrasse = $laStrasse;
        $this->laStrasseNr = $laStrasseNr;
        $this->laPlz = $laPlz;
        $this->laOrt = $laOrt;
        $this->laLand = $laLand;
        $this->laPostfachPlz = $laPostfachPlz;
        $this->laPostfachNr = $laPostfachNr;
        $this->laPfVerwenden = $laPfVerwenden;
        $this->laTelefon = $laTelefon;
        $this->laTelefax = $laTelefax;
        $this->laEmail = $laEmail;
        $this->laLieferart = $laLieferart;
        $this->kfKonto = $kfKonto;
        $this->kfSammelkonto = $kfSammelkonto;
        $this->kfZahlungsbedingungen = $kfZahlungsbedingungen;
        $this->kfErtragkonto = $kfErtragkonto;
        $this->kfWaehrung = $kfWaehrung;
        $this->kfFinanzKonto = $kfFinanzKonto;
        $this->kfPreisangabe = $kfPreisangabe instanceof AdressePreisAngabe ?: new AdressePreisAngabe();
        $this->kfKoSt1 = $kfKoSt1;
        $this->kfKoSt2 = $kfKoSt2;
        $this->kfExterneNr = $kfExterneNr;
        $this->kfLieferstopp = $kfLieferstopp;
        $this->kfRabatt = $kfRabatt;
        $this->kfPreislisteID = $kfPreislisteID;
        $this->kfBankdaten = $kfBankdaten instanceof BankdatenItem ?: new BankdatenItem();
        $this->lfKonto = $lfKonto;
        $this->lfSammelkonto = $lfSammelkonto;
        $this->lfZahlungsbedingungen = $lfZahlungsbedingungen;
        $this->lfAufwandkonto = $lfAufwandkonto;
        $this->lfWaehrung = $lfWaehrung;
        $this->lfFinanzKonto = $lfFinanzKonto;
        $this->lfPreisangabe = $lfPreisangabe instanceof AdressePreisAngabe ?: new AdressePreisAngabe();
        $this->lfKoSt1 = $lfKoSt1;
        $this->lfKoSt2 = $lfKoSt2;
        $this->lfExterneNr = $lfExterneNr;
        $this->lfBestellstopp = $lfBestellstopp;
        $this->lfRabatt = $lfRabatt;
        $this->lfBankdaten = $lfBankdaten instanceof BankdatenItem ?: new BankdatenItem();
        $this->steuergebiet = $steuergebiet instanceof Steuergebiet ?: new Steuergebiet();
        $this->uStId = $uStId;
        $this->belegsprache = $belegsprache;
        $this->briefanrede = $briefanrede;
        $this->briefgruss = $briefgruss;
        $this->notizen = $notizen;
        $this->mailPreferred = $mailPreferred;
        $this->attachmentIdList = $attachmentIdList;
    }

    public function getMatchCode(): string
    {
        return $this->matchCode;
    }

    public function setMatchCode(string $matchCode): void
    {
        $this->matchCode = $matchCode;
    }

    public function getAdressNummer(): string
    {
        return $this->adressNummer;
    }

    public function setAdressNummer(string $adressNummer): void
    {
        $this->adressNummer = $adressNummer;
    }

    public function getKategorie(): string
    {
        return $this->kategorie;
    }

    public function setKategorie(string $kategorie): void
    {
        $this->kategorie = $kategorie;
    }

    public function getKundenStatus(): AdresseStatus
    {
        return $this->kundenStatus;
    }

    public function setKundenStatus(AdresseStatus $kundenStatus): void
    {
        $this->kundenStatus = $kundenStatus;
    }

    public function getLieferantenStatus(): AdresseStatus
    {
        return $this->lieferantenStatus;
    }

    public function setLieferantenStatus(AdresseStatus $lieferantenStatus): void
    {
        $this->lieferantenStatus = $lieferantenStatus;
    }

    /** Rechnungsanschrift */

    public function getRaFirma1(): string
    {
        return $this->raFirma1;
    }

    public function setRaFirma1(string $raFirma1): void
    {
        $this->raFirma1 = $raFirma1;
    }

    public function getRaFirma2(): string
    {
        return $this->raFirma2;
    }

    public function setRaFirma2(string $raFirma2): void
    {
        $this->raFirma2 = $raFirma2;
    }

    public function getRaAnrede(): string
    {
        return $this->raAnrede;
    }

    public function setRaAnrede(string $raAnrede): void
    {
        $this->raAnrede = $raAnrede;
    }

    public function getRaZusatz(): string
    {
        return $this->raZusatz;
    }

    public function setRaZusatz(string $raZusatz): void
    {
        $this->raZusatz = $raZusatz;
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

    public function getRaGeschlecht(): string
    {
        return $this->raGeschlecht;
    }

    public function setRaGeschlecht(string $raGeschlecht): void
    {
        $this->raGeschlecht = $raGeschlecht;
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

    public function getRaLand(): string
    {
        return $this->raLand;
    }

    public function setRaLand(string $raLand): void
    {
        $this->raLand = $raLand;
    }

    public function getRaLandISO(): string
    {
        return $this->raLandISO;
    }

    public function setRaLandISO(string $raLandISO): void
    {
        $this->raLandISO = $raLandISO;
    }

    public function getRaPostfachPlz(): string
    {
        return $this->raPostfachPlz;
    }

    public function setRaPostfachPlz(string $raPostfachPlz): void
    {
        $this->raPostfachPlz = $raPostfachPlz;
    }

    public function getRaPostfachNr(): string
    {
        return $this->raPostfachNr;
    }

    public function setRaPostfachNr(string $raPostfachNr): void
    {
        $this->raPostfachNr = $raPostfachNr;
    }

    public function isRaPfVerwenden(): bool
    {
        return $this->raPfVerwenden;
    }

    public function setRaPfVerwenden(bool $raPfVerwenden): void
    {
        $this->raPfVerwenden = $raPfVerwenden;
    }

    public function getRaTelefon1(): string
    {
        return $this->raTelefon1;
    }

    public function setRaTelefon1(string $raTelefon1): void
    {
        $this->raTelefon1 = $raTelefon1;
    }

    public function getRaTelefon2(): string
    {
        return $this->raTelefon2;
    }

    public function setRaTelefon2(string $raTelefon2): void
    {
        $this->raTelefon2 = $raTelefon2;
    }

    public function getRaTelefon3(): string
    {
        return $this->raTelefon3;
    }

    public function setRaTelefon3(string $raTelefon3): void
    {
        $this->raTelefon3 = $raTelefon3;
    }

    public function getRaTelefax(): string
    {
        return $this->raTelefax;
    }

    public function setRaTelefax(string $raTelefax): void
    {
        $this->raTelefax = $raTelefax;
    }

    public function getRaEmail(): string
    {
        return $this->raEmail;
    }

    public function setRaEmail(string $raEmail): void
    {
        $this->raEmail = $raEmail;
    }

    public function getRaInternet(): string
    {
        return $this->raInternet;
    }

    public function setRaInternet(string $raInternet): void
    {
        $this->raInternet = $raInternet;
    }

    /** Lieferanschrift */

    public function getLaFirma1(): string
    {
        return $this->laFirma1;
    }

    public function setLaFirma1(string $laFirma1): void
    {
        $this->laFirma1 = $laFirma1;
    }

    public function getLaFirma2(): string
    {
        return $this->laFirma2;
    }

    public function setLaFirma2(string $laFirma2): void
    {
        $this->laFirma2 = $laFirma2;
    }

    public function isLaLaVerwenden(): bool
    {
        return $this->laLaVerwenden;
    }

    public function setLaLaVerwenden(bool $laLaVerwenden): void
    {
        $this->laLaVerwenden = $laLaVerwenden;
    }

    public function getLaAnrede(): string
    {
        return $this->laAnrede;
    }

    public function setLaAnrede(string $laAnrede): void
    {
        $this->laAnrede = $laAnrede;
    }

    public function getLaVorname(): string
    {
        return $this->laVorname;
    }

    public function setLaVorname(string $laVorname): void
    {
        $this->laVorname = $laVorname;
    }

    public function getLaNachname(): string
    {
        return $this->laNachname;
    }

    public function setLaNachname(string $laNachname): void
    {
        $this->laNachname = $laNachname;
    }

    public function getLaZusatz(): string
    {
        return $this->laZusatz;
    }

    public function setLaZusatz(string $laZusatz): void
    {
        $this->laZusatz = $laZusatz;
    }

    public function getLaStrasse(): string
    {
        return $this->laStrasse;
    }

    public function setLaStrasse(string $laStrasse): void
    {
        $this->laStrasse = $laStrasse;
    }

    public function getLaStrasseNr(): string
    {
        return $this->laStrasseNr;
    }

    public function setLaStrasseNr(string $laStrasseNr): void
    {
        $this->laStrasseNr = $laStrasseNr;
    }

    public function getLaPlz(): string
    {
        return $this->laPlz;
    }

    public function setLaPlz(string $laPlz): void
    {
        $this->laPlz = $laPlz;
    }

    public function getLaOrt(): string
    {
        return $this->laOrt;
    }

    public function setLaOrt(string $laOrt): void
    {
        $this->laOrt = $laOrt;
    }

    public function getLaLand(): string
    {
        return $this->laLand;
    }

    public function setLaLand(string $laLand): void
    {
        $this->laLand = $laLand;
    }

    public function getLaPostfachPlz(): string
    {
        return $this->laPostfachPlz;
    }

    public function setLaPostfachPlz(string $laPostfachPlz): void
    {
        $this->laPostfachPlz = $laPostfachPlz;
    }

    public function getLaPostfachNr(): string
    {
        return $this->laPostfachNr;
    }

    public function setLaPostfachNr(string $laPostfachNr): void
    {
        $this->laPostfachNr = $laPostfachNr;
    }

    public function isLaPfVerwenden(): bool
    {
        return $this->laPfVerwenden;
    }

    public function setLaPfVerwenden(bool $laPfVerwenden): void
    {
        $this->laPfVerwenden = $laPfVerwenden;
    }

    public function getLaTelefon(): string
    {
        return $this->laTelefon;
    }

    public function setLaTelefon(string $laTelefon): void
    {
        $this->laTelefon = $laTelefon;
    }

    public function getLaTelefax(): string
    {
        return $this->laTelefax;
    }

    public function setLaTelefax(string $laTelefax): void
    {
        $this->laTelefax = $laTelefax;
    }

    public function getLaEmail(): string
    {
        return $this->laEmail;
    }

    public function setLaEmail(string $laEmail): void
    {
        $this->laEmail = $laEmail;
    }

    public function getLaLieferart(): string
    {
        return $this->laLieferart;
    }

    public function setLaLieferart(string $laLieferart): void
    {
        $this->laLieferart = $laLieferart;
    }

    /** Kunde Faktura */

    public function getKfKonto(): int
    {
        return $this->kfKonto;
    }

    public function setKfKonto(int $kfKonto): void
    {
        $this->kfKonto = $kfKonto;
    }

    public function isKfSammelkonto(): bool
    {
        return $this->kfSammelkonto;
    }

    public function setKfSammelkonto(bool $kfSammelkonto): void
    {
        $this->kfSammelkonto = $kfSammelkonto;
    }

    public function getKfZahlungsbedingungen(): string
    {
        return $this->kfZahlungsbedingungen;
    }

    public function setKfZahlungsbedingungen(string $kfZahlungsbedingungen): void
    {
        $this->kfZahlungsbedingungen = $kfZahlungsbedingungen;
    }

    public function getKfErtragkonto(): int
    {
        return $this->kfErtragkonto;
    }

    public function setKfErtragkonto(int $kfErtragkonto): void
    {
        $this->kfErtragkonto = $kfErtragkonto;
    }

    public function getKfWaehrung(): string
    {
        return $this->kfWaehrung;
    }

    public function setKfWaehrung(string $kfWaehrung): void
    {
        $this->kfWaehrung = $kfWaehrung;
    }

    public function getKfFinanzKonto(): int
    {
        return $this->kfFinanzKonto;
    }

    public function setKfFinanzKonto(int $kfFinanzKonto): void
    {
        $this->kfFinanzKonto = $kfFinanzKonto;
    }

    public function getKfPreisangabe(): AdressePreisAngabe
    {
        return $this->kfPreisangabe;
    }

    public function setKfPreisangabe(AdressePreisAngabe $kfPreisangabe): void
    {
        $this->kfPreisangabe = $kfPreisangabe;
    }

    public function getKfKoSt1(): string
    {
        return $this->kfKoSt1;
    }

    public function setKfKoSt1(string $kfKoSt1): void
    {
        $this->kfKoSt1 = $kfKoSt1;
    }

    public function getKfKoSt2(): string
    {
        return $this->kfKoSt2;
    }

    public function setKfKoSt2(string $kfKoSt2): void
    {
        $this->kfKoSt2 = $kfKoSt2;
    }

    public function getKfExterneNr(): string
    {
        return $this->kfExterneNr;
    }

    public function setKfExterneNr(string $kfExterneNr): void
    {
        $this->kfExterneNr = $kfExterneNr;
    }

    public function isKfLieferstopp(): bool
    {
        return $this->kfLieferstopp;
    }

    public function setKfLieferstopp(bool $kfLieferstopp): void
    {
        $this->kfLieferstopp = $kfLieferstopp;
    }

    public function getKfRabatt(): string
    {
        return $this->kfRabatt;
    }

    public function setKfRabatt(string $kfRabatt): void
    {
        $this->kfRabatt = $kfRabatt;
    }

    public function getKfPreislisteID(): string
    {
        return $this->kfPreislisteID;
    }

    public function setKfPreislisteID(string $kfPreislisteID): void
    {
        $this->kfPreislisteID = $kfPreislisteID;
    }

    public function getKfBankdaten(): BankdatenItem
    {
        return $this->kfBankdaten;
    }

    public function setKfBankdaten(BankdatenItem $kfBankdaten): void
    {
        $this->kfBankdaten = $kfBankdaten;
    }

    /** Lieferant Faktura */

    public function getLfKonto(): int
    {
        return $this->lfKonto;
    }

    public function setLfKonto(int $lfKonto): void
    {
        $this->lfKonto = $lfKonto;
    }

    public function isLfSammelkonto(): bool
    {
        return $this->lfSammelkonto;
    }

    public function setLfSammelkonto(bool $lfSammelkonto): void
    {
        $this->lfSammelkonto = $lfSammelkonto;
    }

    public function getLfZahlungsbedingungen(): string
    {
        return $this->lfZahlungsbedingungen;
    }

    public function setLfZahlungsbedingungen(string $lfZahlungsbedingungen): void
    {
        $this->lfZahlungsbedingungen = $lfZahlungsbedingungen;
    }

    public function getLfAufwandkonto(): int
    {
        return $this->lfAufwandkonto;
    }

    public function setLfAufwandkonto(int $lfAufwandkonto): void
    {
        $this->lfAufwandkonto = $lfAufwandkonto;
    }

    public function getLfWaehrung(): string
    {
        return $this->lfWaehrung;
    }

    public function setLfWaehrung(string $lfWaehrung): void
    {
        $this->lfWaehrung = $lfWaehrung;
    }

    public function getLfFinanzKonto(): int
    {
        return $this->lfFinanzKonto;
    }

    public function setLfFinanzKonto(int $lfFinanzKonto): void
    {
        $this->lfFinanzKonto = $lfFinanzKonto;
    }

    public function getLfPreisangabe(): AdressePreisAngabe
    {
        return $this->lfPreisangabe;
    }

    public function setLfPreisangabe(AdressePreisAngabe $lfPreisangabe): void
    {
        $this->lfPreisangabe = $lfPreisangabe;
    }

    public function getLfKoSt1(): string
    {
        return $this->lfKoSt1;
    }

    public function setLfKoSt1(string $lfKoSt1): void
    {
        $this->lfKoSt1 = $lfKoSt1;
    }

    public function getLfKoSt2(): string
    {
        return $this->lfKoSt2;
    }

    public function setLfKoSt2(string $lfKoSt2): void
    {
        $this->lfKoSt2 = $lfKoSt2;
    }

    public function getLfExterneNr(): string
    {
        return $this->lfExterneNr;
    }

    public function setLfExterneNr(string $lfExterneNr): void
    {
        $this->lfExterneNr = $lfExterneNr;
    }

    public function isLfBestellstopp(): bool
    {
        return $this->lfBestellstopp;
    }

    public function setLfBestellstopp(bool $lfBestellstopp): void
    {
        $this->lfBestellstopp = $lfBestellstopp;
    }

    public function getLfRabatt(): string
    {
        return $this->lfRabatt;
    }

    public function setLfRabatt(string $lfRabatt): void
    {
        $this->lfRabatt = $lfRabatt;
    }

    public function getLfBankdaten(): BankdatenItem
    {
        return $this->lfBankdaten;
    }

    public function setLfBankdaten(BankdatenItem $lfBankdaten): void
    {
        $this->lfBankdaten = $lfBankdaten;
    }

    public function getSteuergebiet(): Steuergebiet
    {
        return $this->steuergebiet;
    }

    public function setSteuergebiet(Steuergebiet $steuergebiet): void
    {
        $this->steuergebiet = $steuergebiet;
    }

    public function getUStId(): string
    {
        return $this->uStId;
    }

    public function setUStId(string $uStId): void
    {
        $this->uStId = $uStId;
    }

    public function getBelegsprache(): string
    {
        return $this->belegsprache;
    }

    public function setBelegsprache(string $belegsprache): void
    {
        $this->belegsprache = $belegsprache;
    }

    public function getBriefanrede(): string
    {
        return $this->briefanrede;
    }

    public function setBriefanrede(string $briefanrede): void
    {
        $this->briefanrede = $briefanrede;
    }

    public function getBriefgruss(): string
    {
        return $this->briefgruss;
    }

    public function setBriefgruss(string $briefgruss): void
    {
        $this->briefgruss = $briefgruss;
    }

    public function getNotizen(): string
    {
        return $this->notizen;
    }

    public function setNotizen(string $notizen): void
    {
        $this->notizen = $notizen;
    }

    public function isMailPreferred(): bool
    {
        return $this->mailPreferred;
    }

    public function __toArray(): array
    {
        return [
            'Matchcode' => $this->getMatchCode(),
            'AdressNr' => $this->getAdressNummer(),
            'Kategorie' => $this->getKategorie(),
            'KundenStatus' => $this->getKundenStatus()->getStatus(),
            'LieferantenStatus' => $this->getLieferantenStatus()->getStatus(),
            'RA_Firma1' => $this->getRaFirma1(),
            'RA_Firma2' => $this->getRaFirma2(),
            'RA_Anrede' => $this->getRaAnrede(),
            'RA_Zusatz' => $this->getRaZusatz(),
            'RA_Vorname' => $this->getRaVorname(),
            'RA_Nachname' => $this->getRaNachname(),
            'RA_Plz' => $this->getRaPlz(),
            'RA_Ort' => $this->getRaOrt(),
            'RA_Geschlecht' => $this->getRaGeschlecht(),
            'RA_Strasse' => $this->getRaStrasse(),
            'RA_StrasseNr' => $this->getRaStrasseNr(),
            'RA_Land' => $this->getRaLand(),
            'RA_LandISO' => $this->getRaLandISO(),
            'RA_PostfachPlz' => $this->getRaPostfachPlz(),
            'RA_PostfachNr' => $this->getRaPostfachNr(),
            'RA_PfVerwenden' => $this->isRaPfVerwenden(),
            'RA_Telefon1' => $this->getRaTelefon1(),
            'RA_Telefon2' => $this->getRaTelefon2(),
            'RA_Telefon3' => $this->getRaTelefon3(),
            'RA_Telefax' => $this->getRaTelefax(),
            'RA_Email' => $this->getRaEmail(),
            'RA_Internet' => $this->getRaInternet(),
            'LA_Firma1' => $this->getLaFirma1(),
            'LA_Firma2' => $this->getLaFirma2(),
            'LA_LaVerwenden' => $this->isLaLaVerwenden(), // Todo: Looks weird
            'LA_Anrede' => $this->getLaAnrede(),
            'LA_Vorname' => $this->getLaVorname(),
            'LA_Nachname' => $this->getLaNachname(),
            'LA_Zusatz' => $this->getLaZusatz(),
            'LA_Strasse' => $this->getLaStrasse(),
            'LA_StrasseNr' => $this->getLaStrasseNr(),
            'LA_Plz' => $this->getLaPlz(),
            'LA_Ort' => $this->getLaOrt(),
            'LA_Land' => $this->getLaLand(),
            'LA_PostfachPlz' => $this->getLaPostfachPlz(),
            'LA_PostfachNr' => $this->getLaPostfachPlz(),
            'LA_PfVerwenden' => $this->isLaPfVerwenden(),
            'LA_Telefon' => $this->getLaTelefon(),
            'LA_Telefax' => $this->getLaTelefax(),
            'LA_Email' => $this->getLaEmail(),
            'LA_Lieferart' => $this->getLaLieferart(),
            'KF_Zahlungsbedingungen' => $this->getKfZahlungsbedingungen(),
            'KF_Preisangabe' => $this->getKfPreisangabe()->getAngabe(),
            'KF_ExterneNr' => $this->getKfExterneNr(),
            'KF_Lieferstopp' => $this->isKfLieferstopp(),
            'KF_Rabatt' => $this->getKfRabatt(),
            'KF_KoSt1' => $this->getKfKoSt1(),
            'KF_KoSt2' => $this->getKfKoSt2(),
            'KF_PreislisteID' => $this->getKfPreislisteID(),
            'KF_Ertragkonto' => $this->getKfErtragkonto(),
            'KF_Konto' => $this->getKfKonto(),
            'KF_Sammelkonto' => $this->isKfSammelkonto(),
            'KF_Waehrung' => $this->getKfWaehrung(),
            'KF_FinanzKonto' => $this->getKfFinanzKonto(),
            'KF_Bankdaten' => $this->getKfBankdaten()->toArray(),
            'LF_Zahlungsbedingungen' => $this->getLfZahlungsbedingungen(),
            'LF_Preisangabe' => $this->getLfPreisangabe()->getAngabe(),
            'LF_ExterneNr' => $this->getLfExterneNr(),
            'LF_Bestellstopp' => $this->isLfBestellstopp(),
            'LF_Rabatt' => $this->getLfRabatt(),
            'LF_KoSt1' => $this->getLfKoSt1(),
            'LF_KoSt2' => $this->getLfKoSt2(),
            'LF_Aufwandkonto' => $this->getLfAufwandkonto(),
            'LF_Konto' => $this->getLfKonto(),
            'LF_Sammelkonto' => $this->isLfSammelkonto(),
            'LF_Waehrung' => $this->getLfWaehrung(),
            'LF_FinanzKonto' => $this->getLfFinanzKonto(),
            'LF_Bankdaten' => $this->getLfBankdaten()->toArray(),
            'Steuergebiet' => $this->getSteuergebiet()->getGebiet(),
            'UStID' => $this->getUStId(),
            'Belegsprache' => $this->getBelegsprache(),
            'Briefanrede' => $this->getBriefanrede(),
            'Briefgruss' => $this->getBriefgruss(),
            'Notizen' => $this->getNotizen(),
            'Mail_Preferred' => $this->isMailPreferred(),
        ];
    }
}
