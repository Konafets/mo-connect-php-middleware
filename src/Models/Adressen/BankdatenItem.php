<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use stdClass;

class BankdatenItem
{
    protected string $iban = '';
    protected string $bic = '';
    protected string $bank = '';
    protected string $inhaber = '';

    public function __construct(string $iban = '', string $bic = '', string $bank = '', string $inhaber = '')
    {
        $this->iban = $iban;
        $this->bic = $bic;
        $this->bank = $bank;
        $this->inhaber = $inhaber;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->BankdatenItem->IBAN,
            $response->BankdatenItem->BIC,
            $response->BankdatenItem->Bank,
            $response->BankdatenItem->Inhaber,
        );
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

    public function getBank(): string
    {
        return $this->bank;
    }

    public function setBank(string $bank): void
    {
        $this->bank = $bank;
    }

    public function getInhaber(): string
    {
        return $this->inhaber;
    }

    public function setInhaber(string $inhaber): void
    {
        $this->inhaber = $inhaber;
    }

    public function toArray(): array
    {
        return [
            'BankdatenItem' => [
                'IBAN' => $this->getIban(),
                'BIC' => $this->getBic(),
                'Bank' => $this->getBank(),
                'Inhaber' => $this->getInhaber(),
            ]
        ];
    }


}
