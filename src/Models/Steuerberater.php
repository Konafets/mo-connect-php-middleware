<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

class Steuerberater
{
    protected string $name = '';

    protected string $additional = '';

    protected Location $location;

//    protected string $street = '';
//
//    protected string $zip = '';
//
//    protected string $location = '';

    protected Contact $contact;
//    protected string $sbTelefon = '';
//
//    protected string $sbTelefax = '';
//
//    protected string $sbEmail = '';

    protected BankAccount $bankAccount;

//    protected string $sbBankName = '';
//
//    protected string $sbBankIban = '';
//
//    protected string $sbBankBic = '';

    protected string $memo = '';

    public function __construct(
        string $name,
        string $additional,
        Location $location,
        Contact $contact,
        BankAccount $bankAccount,
        string $memo
    ) {
        $this->name = $name;
        $this->additional = $additional;
        $this->location = $location;
        $this->contact = $contact;
        $this->bankAccount = $bankAccount;
        $this->memo = $memo;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAdditional(): string
    {
        return $this->additional;
    }

    public function setAdditional(string $additional): void
    {
        $this->additional = $additional;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
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

    public function getContact(): Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): void
    {
        $this->contact = $contact;
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

    public function setTelefax(string $fax): void
    {
        $this->contact->setTelefax($fax);
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

    public function getBankAccount(): BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
    }

    public function getBankName(): string
    {
        return $this->bankAccount->getName();
    }

    public function setBankName(string $bankName): void
    {
        $this->bankAccount->setName($bankName);
    }

    public function getIban(): string
    {
        return $this->bankAccount->getIban();
    }

    public function setIban(string $iban): void
    {
        $this->bankAccount->setIban($iban);
    }

    public function getBic(): string
    {
        return $this->bankAccount->getBic();
    }

    public function setBic(string $bic): void
    {
        $this->bankAccount->setBic($bic);
    }

    public function getMemo(): string
    {
        return $this->memo;
    }

    public function setMemo(string $memo): void
    {
        $this->memo = $memo;
    }
}
