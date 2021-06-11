<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

class Contact
{
    protected string $telefon = '';

    protected string $telefax = '';

    protected string $email = '';

    protected ?string $internet;

    public function __construct(string $telefon, string $telefax, string $email, string $internet = null)
    {
        $this->telefon = $telefon;
        $this->telefax = $telefax;
        $this->email = $email;
        $this->internet = $internet;
    }

    public function getTelefon(): string
    {
        return $this->telefon;
    }

    public function setTelefon(string $telefon): void
    {
        $this->telefon = $telefon;
    }

    public function getTelefax(): string
    {
        return $this->telefax;
    }

    public function setTelefax(string $telefax): void
    {
        $this->telefax = $telefax;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getInternet(): string
    {
        return $this->internet;
    }

    public function setInternet(string $internet): void
    {
        $this->internet = $internet;
    }
}
