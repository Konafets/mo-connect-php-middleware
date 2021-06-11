<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

class Finanzamt
{
    protected string $country = '';

    protected string $number = '';

    protected string $name = '';

    protected string $additional = '';

    protected string $street = '';

    protected string $zip = '';

    protected string $location = '';

    protected string $state = '';

    protected string $taxNumberPrefix = '';

    protected string $taxNumber = '';

    protected string $taxNumberPostfix = '';

    protected string $phone = '';

    protected string $fax = '';

    protected BankAccount $bankAccount;

    protected string $memo = '';

    public function __construct(
        string $country,
        string $number,
        string $name,
        string $additional,
        string $street,
        string $zip,
        string $location,
        string $state,
        string $taxNumberPrefix,
        string $taxNumber,
        string $taxNumberPostfix,
        BankAccount $bankAccount,
        string $phone,
        string $fax,
        string $memo
    ) {
        $this->country = $country;
        $this->number = $number;
        $this->name = $name;
        $this->additional = $additional;
        $this->street = $street;
        $this->zip = $zip;
        $this->location = $location;
        $this->state = $state;
        $this->taxNumberPrefix = $taxNumberPrefix;
        $this->taxNumber = $taxNumber;
        $this->taxNumberPostfix = $taxNumberPostfix;
        $this->bankAccount = $bankAccount;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->memo = $memo;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['country'],
            $data['number'],
            $data['name'],
            $data['additional'],
            $data['street'],
            $data['zip'],
            $data['location'],
            $data['state'],
            $data['taxNumberPrefix'],
            $data['taxNumber'],
            $data['taxNumberPostfix'],
            $data['bankDetails'],
            $data['phone'],
            $data['fax'],
            $data['memo'],
        );
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
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

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getTaxNumberPrefix(): string
    {
        return $this->taxNumberPrefix;
    }

    public function setTaxNumberPrefix(string $taxNumberPrefix): void
    {
        $this->taxNumberPrefix = $taxNumberPrefix;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    public function getTaxNumberPostfix(): string
    {
        return $this->taxNumberPostfix;
    }

    public function setTaxNumberPostfix(string $taxNumberPostfix): void
    {
        $this->taxNumberPostfix = $taxNumberPostfix;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function setFax(string $fax): void
    {
        $this->fax = $fax;
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

    public function getBankAccount(): BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
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
