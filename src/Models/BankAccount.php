<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

class BankAccount
{
    protected string $iban = '';

    protected string $bic = '';

    protected string $name = '';

    public function __construct(string $iban, string $bic, string $name)
    {
        $this->iban = $iban;
        $this->bic = $bic;
        $this->name = $name;
    }

    public function getIban(): string
    {
        return $this->iban;
    }

    public function setIban(string $iban): void
    {
        $this->iban = $iban;
    }

    public function getBic(): string
    {
        return $this->bic;
    }

    public function setBic(string $bic): void
    {
        $this->bic = $bic;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
