<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Firmen;

use ArrobaIt\MoConnectApi\Models\BankAccount;
use ArrobaIt\MoConnectApi\Models\Contact;
use ArrobaIt\MoConnectApi\Models\Finanzamt;
use ArrobaIt\MoConnectApi\Models\Location;
use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use ArrobaIt\MoConnectApi\Models\Steuerberater;
use Carbon\Carbon;
use stdClass;

class FirmaItem
{
    use ResponseTrait;

    /**
     * @var string
     * @see Firma_Name
     */
    protected string $name = '';

    /**
     * @var string
     * @see Firma_Zusatz
     */
    protected string $zusatz = '';

    /**
     * @var string
     * @see Firma_Geschaeftsfuehrer
     */
    protected string $geschaeftsfuehrer = '';

    protected Location $location;

    protected Contact $contact;

    /**
     * @var string
     * @see Firma_RegisterGericht
     */
    protected string $registerGericht = '';

    /**
     * @var string
     * @see Firma_RegisterNummer
     */
    protected string $registerNummer = '';

    protected BankAccount $bankKonto;

    /**
     * @var bool
     * @see Firma_UStPflicht
     */
    protected bool $ustPflicht = false;

    /**
     * @var string
     * @see Firma_UStIDNummer
     */
    protected string $ustIdNummer = '';

    /**
     * @var string
     * @see Firma_Kontenplan
     */
    protected string $kontenplan = '';

    /**
     * Art der Gewinnermittlung
     *
     * @var int
     * @see Firma_GEArt
     */
    protected int $geArt;

    protected Finanzamt $finanzamt;

    protected Steuerberater $steuerberater;

    protected Finanzamt $finanzamtLohnsteuer;

    /**
     * Lieferanschrift | Name
     *
     * @var string
     * @see Firma_LGName
     */
    protected string $lgName = '';

    /**
     * Lieferanschrift | Zusatz
     *
     * @var string
     * @see Firma_LGZusatz
     */
    protected string $lgZusatz = '';

    /**
     * Lieferanschrift | Verwalter
     *
     * @var string
     * @see Firma_LGVerwalter
     */
    protected string $lgVerwalter = '';

    /**
     * Lieferanschrift | Strasse
     *
     * @var string
     * @see Firma_LGStrasse
     */
    protected string $lgStrasse = '';

    /**
     * Lieferanschrift | Plz
     *
     * @var string
     * @see Firma_LGPlz
     */
    protected string $lgPlz = '';

    /**
     * Lieferanschrift | Ort
     *
     * @var string
     * @see Firma_LGOrt
     */
    protected string $lgOrt = '';

    /**
     * Lieferanschrift | Telefon
     *
     * @var string
     * @see Firma_LGTelefon
     */
    protected string $lgTelefon = '';

    /**
     * Lieferanschrift | Telefax
     *
     * @var string
     * @see Firma_LGTelefax
     */
    protected string $lgTelefax = '';

    /**
     * Lieferanschrift | Email
     *
     * @var string
     * @see Firma_LGEmail
     */
    protected string $lgEmail = '';

    protected Carbon $datumVon;

    protected Carbon $datumBis;

    public function __construct(
        string $name,
        string $zusatz,
        string $geschaeftsfuehrer,
        Location $location,
        Contact $contact,
        string $registerGericht,
        string $registerNummer,
        BankAccount $bankKonto,
        bool $ustPflicht,
        string $ustIdNummer,
        string $kontenplan,
        int $geArt,
        Finanzamt $finanzamt,
        Steuerberater $steuerberater,
        Finanzamt $finanzamtLohnsteuer,
        string $lgName,
        string $lgZusatz,
        string $lgVerwalter,
        string $lgStrasse,
        string $lgPlz,
        string $lgOrt,
        string $lgTelefon,
        string $lgTelefax,
        string $lgEmail,
        Carbon $datumVon,
        Carbon $datumBis
    ) {
        $this->name = $name;
        $this->zusatz = $zusatz;
        $this->geschaeftsfuehrer = $geschaeftsfuehrer;
        $this->location = $location;
        $this->contact = $contact;
        $this->registerGericht = $registerGericht;
        $this->registerNummer = $registerNummer;
        $this->bankKonto = $bankKonto;
        $this->ustPflicht = $ustPflicht;
        $this->ustIdNummer = $ustIdNummer;
        $this->kontenplan = $kontenplan;
        $this->geArt = $geArt;
        $this->finanzamt = $finanzamt;
        $this->steuerberater = $steuerberater;
        $this->finanzamtLohnsteuer = $finanzamtLohnsteuer;
        $this->lgName = $lgName;
        $this->lgZusatz = $lgZusatz;
        $this->lgVerwalter = $lgVerwalter;
        $this->lgStrasse = $lgStrasse;
        $this->lgPlz = $lgPlz;
        $this->lgOrt = $lgOrt;
        $this->lgTelefon = $lgTelefon;
        $this->lgTelefax = $lgTelefax;
        $this->lgEmail = $lgEmail;
        $this->datumVon = $datumVon;
        $this->datumBis = $datumBis;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        $firmaItem = $response->FirmaItem;

        $bankAccount = new BankAccount(
            $firmaItem->Firma_BankIBAN,
            $firmaItem->Firma_BankBIC,
            $firmaItem->Firma_BankName
        );

        $steuerberater = new Steuerberater(
            $firmaItem->Firma_SBName,
            $firmaItem->Firma_SBZusatz,
            new Location($firmaItem->Firma_SBStrasse, $firmaItem->Firma_SBPlz, $firmaItem->Firma_SBOrt),
            new Contact($firmaItem->Firma_SBTelefon, $firmaItem->Firma_SBTelefax, $firmaItem->Firma_SBEmail),
            new BankAccount($firmaItem->Firma_SBBankIBAN, $firmaItem->Firma_SBBankBIC, $firmaItem->Firma_SBBankName),
            $firmaItem->Firma_SBMemo
        );

        $finanzamt = Finanzamt::fromArray([
            'name' => $firmaItem->Firma_FAName,
            'country' => $firmaItem->Firma_FALand,
            'number' => $firmaItem->Firma_FANummer,
            'additional' => $firmaItem->Firma_FAZusatz,
            'street' => $firmaItem->Firma_FAStrasse,
            'zip' => $firmaItem->Firma_FAPlz,
            'location' => $firmaItem->Firma_FAOrt,
            'state' => $firmaItem->Firma_FABundesland,
            'taxNumberPrefix' => $firmaItem->Firma_FAStNrPrefix,
            'taxNumber' => $firmaItem->Firma_FASteuernummer,
            'taxNumberPostfix' => $firmaItem->Firma_FAStNrPostfix,
            'bankDetails' => new BankAccount(
                $firmaItem->Firma_FABankIBAN,
                $firmaItem->Firma_FABankBIC,
                $firmaItem->Firma_FABankName,
            ),
            'phone' => $firmaItem->Firma_FATelefon,
            'fax' => $firmaItem->Firma_FATelefax,
            'memo' => $firmaItem->Firma_FAMemo,
        ]);

        $finanzamtLohnsteuer = Finanzamt::fromArray([
            'name' => $firmaItem->Firma_FANameLSt,
            'country' => $firmaItem->Firma_FALandLSt,
            'number' => $firmaItem->Firma_FANummerLSt,
            'additional' => $firmaItem->Firma_FAZusatzLSt,
            'street' => $firmaItem->Firma_FAStrasseLSt,
            'zip' => $firmaItem->Firma_FAPlzLSt,
            'location' => $firmaItem->Firma_FAOrtLSt,
            'state' => $firmaItem->Firma_FABundeslandLSt,
            'taxNumberPrefix' => $firmaItem->Firma_FAStNrPrefixLSt,
            'taxNumber' => $firmaItem->Firma_FASteuernummerLSt,
            'taxNumberPostfix' => $firmaItem->Firma_FAStNrPostfixLSt,
            'bankDetails' => new BankAccount(
                $firmaItem->Firma_FABankIBANLSt,
                $firmaItem->Firma_FABankBICLSt,
                $firmaItem->Firma_FABankNameLSt,
            ),
            'phone' => $firmaItem->Firma_FATelefonLSt,
            'fax' => $firmaItem->Firma_FATelefaxLSt,
            'memo' => $firmaItem->Firma_FAMemoLSt,
        ]);

        $location = new Location(
            $firmaItem->Firma_Strasse,
            $firmaItem->Firma_Plz,
            $firmaItem->Firma_Ort
        );

        $contact = new Contact(
            $firmaItem->Firma_Telefon,
            $firmaItem->Firma_Telefax,
            $firmaItem->Firma_Email,
            $firmaItem->Firma_Internet,
        );

        return new self(
            $firmaItem->Firma_Name,
            $firmaItem->Firma_Zusatz,
            $firmaItem->Firma_Geschaeftsfuehrer,
            $location,
            $contact,
            $firmaItem->Firma_RegisterGericht,
            $firmaItem->Firma_RegisterNummer,
            $bankAccount,
            $firmaItem->Firma_UStPflicht,
            $firmaItem->Firma_UStIDNummer,
            $firmaItem->Firma_Kontenplan,
            $firmaItem->Firma_GEArt,
            $finanzamt,
            $steuerberater,
            $finanzamtLohnsteuer,
            $firmaItem->Firma_LGName,
            $firmaItem->Firma_LGZusatz,
            $firmaItem->Firma_LGVerwalter,
            $firmaItem->Firma_LGStrasse,
            $firmaItem->Firma_LGPlz,
            $firmaItem->Firma_LGOrt,
            $firmaItem->Firma_LGTelefon,
            $firmaItem->Firma_LGTelefax,
            $firmaItem->Firma_LGEmail,
            Carbon::createFromFormat('Y-m-d', $firmaItem->DatumVon),
            Carbon::createFromFormat('Y-m-d', $firmaItem->DatumBis)
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getZusatz(): string
    {
        return $this->zusatz;
    }

    public function setZusatz(string $zusatz): void
    {
        $this->zusatz = $zusatz;
    }

    public function getGeschaeftsfuehrer(): string
    {
        return $this->geschaeftsfuehrer;
    }

    public function setGeschaeftsfuehrer(string $geschaeftsfuehrer): void
    {
        $this->geschaeftsfuehrer = $geschaeftsfuehrer;
    }

    public function getStrasse(): string
    {
        return $this->location->getStrasse();
    }

    public function setStrasse(string $strasse): void
    {
        $this->location->setStrasse($strasse);
    }

    public function getPlz(): string
    {
        return $this->location->getPlz();
    }

    public function setPlz(string $plz): void
    {
        $this->location->setPlz($plz);
    }

    public function getOrt(): string
    {
        return $this->location->getOrt();
    }

    public function setOrt(string $ort): void
    {
        $this->location->setOrt($ort);
    }

    public function getTelefon(): string
    {
        return $this->contact->getTelefon();
    }

    public function setTelefon(string $telefon): void
    {
        $this->contact->setTelefon($telefon);
    }

    public function getTelefax(): string
    {
        return $this->contact->getTelefax();
    }

    public function setTelefax(string $telefax): void
    {
        $this->contact->setTelefax($telefax);
    }

    public function getEmail(): string
    {
        return $this->contact->getEmail();
    }

    public function setEmail(string $email): void
    {
        $this->contact->setEmail($email);
    }

    public function getInternet(): string
    {
        return $this->contact->getInternet();
    }

    public function setInternet(string $internet): void
    {
        $this->contact->setInternet($internet);
    }

    public function getRegisterGericht(): string
    {
        return $this->registerGericht;
    }

    public function setRegisterGericht(string $registerGericht): void
    {
        $this->registerGericht = $registerGericht;
    }

    public function getRegisterNummer(): string
    {
        return $this->registerNummer;
    }

    public function setRegisterNummer(string $registerNummer): void
    {
        $this->registerNummer = $registerNummer;
    }

    /**
     * @see Firma_BankIBAN
     */
    public function getIban(): string
    {
        return $this->bankKonto->getIban();
    }

    public function setIban(string $iban): void
    {
        $this->bankKonto->setIban($iban);
    }

    /**
     * @see Firma_BankBIC
     */
    public function getBic(): string
    {
        return $this->bankKonto->getBic();
    }

    public function setBic(string $bic): void
    {
        $this->bankKonto->setBic($bic);
    }

    /**
     * @see Firma_BankName
     */
    public function getBankName(): string
    {
        return $this->bankKonto->getName();
    }

    public function setBankName(string $bankName): void
    {
        $this->bankKonto->setName($bankName);
    }

    public function getUstPflicht(): bool
    {
        return $this->ustPflicht;
    }

    public function setUstPflicht(bool $ustPflicht): void
    {
        $this->ustPflicht = $ustPflicht;
    }

    public function getUstIdNummer(): string
    {
        return $this->ustIdNummer;
    }

    public function setUstIdNummer(string $ustIdNummer): void
    {
        $this->ustIdNummer = $ustIdNummer;
    }

    public function getKontenplan(): string
    {
        return $this->kontenplan;
    }

    public function setKontenplan(string $kontenplan): void
    {
        $this->kontenplan = $kontenplan;
    }

    public function getGeArt(): int
    {
        return $this->geArt;
    }

    public function setGeArt(int $geArt): void
    {
        $this->geArt = $geArt;
    }

    public function getFaLand(): string
    {
        return $this->finanzamt->getCountry();
    }

    public function setFaLand(string $faLand): void
    {
        $this->finanzamt->setCountry($faLand);
    }

    public function getFaNummber(): string
    {
        return $this->finanzamt->getNumber();
    }

    public function setFaNummber(string $faNummber): void
    {
        $this->finanzamt->setNumber($faNummber);
    }

    public function getFaName(): string
    {
        return $this->finanzamt->getName();
    }

    public function setFaName(string $faName): void
    {
        $this->finanzamt->setName($faName);
    }

    public function getFaZusatz(): string
    {
        return $this->finanzamt->getAdditional();
    }

    public function setFaZusatz(string $faZusatz): void
    {
        $this->finanzamt->setAdditional($faZusatz);
    }

    public function getFaStrasse(): string
    {
        return $this->finanzamt->getStreet();
    }

    public function setFaStrasse(string $faStrasse): void
    {
        $this->finanzamt->setStreet($faStrasse);
    }

    public function getFaPlz(): string
    {
        return $this->finanzamt->getZip();
    }

    public function setFaPlz(string $faPlz): void
    {
        $this->finanzamt->setZip($faPlz);
    }

    public function getFaOrt(): string
    {
        return $this->finanzamt->getLocation();
    }

    public function setFaOrt(string $faOrt): void
    {
        $this->finanzamt->setLocation($faOrt);
    }

    public function getFaBundesland(): string
    {
        return $this->finanzamt->getState();
    }

    public function setFaBundesland(string $faBundesland): void
    {
        $this->finanzamt->setState($faBundesland);
    }

    public function getFaStNrPrefix(): string
    {
        return $this->finanzamt->getTaxNumberPrefix();
    }

    public function setFaStNrPrefix(string $faStNrPrefix): void
    {
        $this->finanzamt->setTaxNumberPrefix($faStNrPrefix);
    }

    public function getFaSteuernummer(): string
    {
        return $this->finanzamt->getTaxNumber();
    }

    public function setFaSteuernummer(string $faSteuernummer): void
    {
        $this->finanzamt->setTaxNumber($faSteuernummer);
    }

    public function getFaStNrPostfix(): string
    {
        return $this->finanzamt->getTaxNumberPostfix();
    }

    public function setFaStNrPostfix(string $faStNrPostfix): void
    {
        $this->finanzamt->setTaxNumberPostfix($faStNrPostfix);
    }

    public function getFaTelefon(): string
    {
        return $this->finanzamt->getPhone();
    }

    public function setFaTelefon(string $faTelefon): void
    {
        $this->finanzamt->setPhone($faTelefon);
    }

    public function getFaTelefax(): string
    {
        return $this->finanzamt->getFax();
    }

    public function setFaTelefax(string $faTelefax): void
    {
        $this->finanzamt->setFax($faTelefax);
    }

    public function getFaBankName(): string
    {
        return $this->finanzamt->getBankName();
    }

    public function setFaBankName(string $faBankName): void
    {
        $this->finanzamt->setBankName($faBankName);
    }

    public function getFaBankIban(): string
    {
        return $this->finanzamt->getIban();
    }

    public function setFaBankIban(string $faBankIban): void
    {
        $this->finanzamt->setIban($faBankIban);
    }

    public function getFaBankBic(): string
    {
        return $this->finanzamt->getBic();
    }

    public function setFaBankBic(string $faBankBic): void
    {
        $this->finanzamt->setBic($faBankBic);
    }

    public function getFaMemo(): string
    {
        return $this->finanzamt->getMemo();
    }

    public function setFaMemo(string $faMemo): void
    {
        $this->finanzamt->setMemo($faMemo);
    }

    public function getSbName(): string
    {
        return $this->steuerberater->getName();
    }

    public function setSbName(string $sbName): void
    {
        $this->steuerberater->setName($sbName);
    }

    public function getSbZusatz(): string
    {
        return $this->steuerberater->getAdditional();
    }

    public function setSbZusatz(string $sbZusatz): void
    {
        $this->steuerberater->setAdditional($sbZusatz);
    }

    public function getSbStrasse(): string
    {
        return $this->steuerberater->getStrasse();
    }

    public function setSbStrasse(string $sbStrasse): void
    {
        $this->steuerberater->setStrasse($sbStrasse);
    }

    public function getSbPlz(): string
    {
        return $this->steuerberater->getPlz();
    }

    public function setSbPlz(string $sbPlz): void
    {
        $this->steuerberater->setPlz($sbPlz);
    }

    public function getSbOrt(): string
    {
        return $this->steuerberater->getOrt();
    }

    public function setSbOrt(string $sbOrt): void
    {
        $this->steuerberater->setOrt($sbOrt);
    }

    public function getSbTelefon(): string
    {
        return $this->steuerberater->getTelefon();
    }

    public function setSbTelefon(string $sbTelefon): void
    {
        $this->steuerberater->setTelefon($sbTelefon);
    }

    public function getSbTelefax(): string
    {
        return $this->steuerberater->getTelefax();
    }

    public function setSbTelefax(string $sbTelefax): void
    {
        $this->steuerberater->setTelefax($sbTelefax);
    }

    public function getSbEmail(): string
    {
        return $this->steuerberater->getEmail();
    }

    public function setSbEmail(string $sbEmail): void
    {
        $this->steuerberater->setEmail($sbEmail);
    }

    public function getSbBankName(): string
    {
        return $this->steuerberater->getBankName();
    }

    public function setSbBankName(string $sbBankName): void
    {
        $this->steuerberater->setBankName($sbBankName);
    }

    public function getSbBankIban(): string
    {
        return $this->steuerberater->getIban();
    }

    public function setSbBankIban(string $sbBankIban): void
    {
        $this->steuerberater->setIban($sbBankIban);
    }

    public function getSbBankBic(): string
    {
        return $this->steuerberater->getBic();
    }

    public function setSbBankBic(string $sbBankBic): void
    {
        $this->steuerberater->setBic($sbBankBic);
    }

    public function getSbMemo(): string
    {
        return $this->steuerberater->getMemo();
    }

    public function setSbMemo(string $sbMemo): void
    {
        $this->steuerberater->setMemo($sbMemo);
    }

    public function getFaLandLSt(): string
    {
        return $this->finanzamtLohnsteuer->getCountry();
    }

    public function setFaLandLSt(string $faLandLSt): void
    {
        $this->finanzamtLohnsteuer->setCountry($faLandLSt);
    }

    public function getFaNummerLSt(): string
    {
        return $this->finanzamtLohnsteuer->getNumber();
    }

    public function setFaNummerLSt(string $faNummerLSt): void
    {
        $this->finanzamtLohnsteuer->setNumber($faNummerLSt);
    }

    public function getFaNameLSt(): string
    {
        return $this->finanzamtLohnsteuer->getName();
    }

    public function setFaNameLSt(string $faNameLSt): void
    {
        $this->finanzamtLohnsteuer->setName($faNameLSt);
    }

    public function getFaZusatzLSt(): string
    {
        return $this->finanzamtLohnsteuer->getAdditional();
    }

    public function setFaZusatzLSt(string $faZusatzLSt): void
    {
        $this->finanzamtLohnsteuer->setAdditional($faZusatzLSt);
    }

    public function getFaStrasseLSt(): string
    {
        return $this->finanzamtLohnsteuer->getStreet();
    }

    public function setFaStrasseLSt(string $faStrasseLSt): void
    {
        $this->finanzamtLohnsteuer->setStreet($faStrasseLSt);
    }

    public function getFaPlzLSt(): string
    {
        return $this->finanzamtLohnsteuer->getZip();
    }

    public function setFaPlzLSt(string $faPlzLSt): void
    {
        $this->finanzamtLohnsteuer->setZip($faPlzLSt);
    }

    public function getFaOrtLSt(): string
    {
        return $this->finanzamtLohnsteuer->getLocation();
    }

    public function setFaOrtLSt(string $faOrtLSt): void
    {
        $this->finanzamtLohnsteuer->setLocation($faOrtLSt);
    }

    public function getFaBundeslandLSt(): string
    {
        return $this->finanzamtLohnsteuer->getState();
    }

    public function setFaBundeslandLSt(string $faBundeslandLSt): void
    {
        $this->finanzamtLohnsteuer->setState($faBundeslandLSt);
    }

    public function getFaStNrPrefixLSt(): string
    {
        return $this->finanzamtLohnsteuer->getTaxNumberPrefix();
    }

    public function setFaStNrPrefixLSt(string $faStNrPrefixLSt): void
    {
        $this->finanzamtLohnsteuer->setTaxNumberPrefix($faStNrPrefixLSt);
    }

    public function getFaSteuernummerLSt(): string
    {
        return $this->finanzamtLohnsteuer->getTaxNumber();
    }

    public function setFaSteuernummerLSt(string $faSteuernummerLSt): void
    {
        $this->finanzamtLohnsteuer->setTaxNumber($faSteuernummerLSt);
    }

    public function getFaStNrPostfixLSt(): string
    {
        return $this->finanzamtLohnsteuer->getTaxNumberPostfix();
    }

    public function setFaStNrPostfixLSt(string $faStNrPostfixLSt): void
    {
        $this->finanzamtLohnsteuer->setTaxNumberPostfix($faStNrPostfixLSt);
    }

    public function getFaTelefonLSt(): string
    {
        return $this->finanzamtLohnsteuer->getPhone();
    }

    public function setFaTelefonLSt(string $faTelefonLSt): void
    {
        $this->finanzamtLohnsteuer->setPhone($faTelefonLSt);
    }

    public function getFaTelefaxLSt(): string
    {
        return $this->finanzamtLohnsteuer->getFax();
    }

    public function setFaTelefaxLSt(string $faTelefaxLSt): void
    {
        $this->finanzamtLohnsteuer->setFax($faTelefaxLSt);
    }

    public function getFaBankNameLSt(): string
    {
        return $this->finanzamtLohnsteuer->getBankName();
    }

    public function setFaBankNameLSt(string $faBankNameLSt): void
    {
        $this->finanzamtLohnsteuer->setBankName($faBankNameLSt);
    }

    public function getFaBankIbanLSt(): string
    {
        return $this->finanzamtLohnsteuer->getIban();
    }

    public function setFaBankIbanLSt(string $faBankIbanLSt): void
    {
        $this->finanzamtLohnsteuer->setIban($faBankIbanLSt);
    }

    public function getFaBankBicLSt(): string
    {
        return $this->finanzamtLohnsteuer->getBic();
    }

    public function setFaBankBicLSt(string $faBankBicLSt): void
    {
        $this->finanzamtLohnsteuer->setBic($faBankBicLSt);
    }

    public function getFaMemoLSt(): string
    {
        return $this->finanzamtLohnsteuer->getMemo();
    }

    public function setFaMemoLSt(string $faMemoLSt): void
    {
        $this->finanzamtLohnsteuer->setMemo($faMemoLSt);
    }

    public function getLgName(): string
    {
        return $this->lgName;
    }

    public function setLgName(string $lgName): void
    {
        $this->lgName = $lgName;
    }

    public function getLgZusatz(): string
    {
        return $this->lgZusatz;
    }

    public function setLgZusatz(string $lgZusatz): void
    {
        $this->lgZusatz = $lgZusatz;
    }

    public function getLgVerwalter(): string
    {
        return $this->lgVerwalter;
    }

    public function setLgVerwalter(string $lgVerwalter): void
    {
        $this->lgVerwalter = $lgVerwalter;
    }


    public function getLgStrasse(): string
    {
        return $this->lgStrasse;
    }

    public function setLgStrasse(string $lgStrasse): void
    {
        $this->lgStrasse = $lgStrasse;
    }

    public function getLgPlz(): string
    {
        return $this->lgPlz;
    }

    public function setLgPlz(string $lgPlz): void
    {
        $this->lgPlz = $lgPlz;
    }

    public function getLgOrt(): string
    {
        return $this->lgOrt;
    }

    public function setLgOrt(string $lgOrt): void
    {
        $this->lgOrt = $lgOrt;
    }

    public function getLgTelefon(): string
    {
        return $this->lgTelefon;
    }

    public function setLgTelefon(string $lgTelefon): void
    {
        $this->lgTelefon = $lgTelefon;
    }

    public function getLgTelefax(): string
    {
        return $this->lgTelefax;
    }

    public function setLgTelefax(string $lgTelefax): void
    {
        $this->lgTelefax = $lgTelefax;
    }

    public function getLgEmail(): string
    {
        return $this->lgEmail;
    }

    public function setLgEmail(string $lgEmail): void
    {
        $this->lgEmail = $lgEmail;
    }

    public function getDatumVon(): Carbon
    {
        return $this->datumVon;
    }

    public function setDatumVon(Carbon $datumVon): void
    {
        $this->datumVon = $datumVon;
    }

    public function getDatumBis(): Carbon
    {
        return $this->datumBis;
    }

    public function setDatumBis(Carbon $datumBis): void
    {
        $this->datumBis = $datumBis;
    }
}
