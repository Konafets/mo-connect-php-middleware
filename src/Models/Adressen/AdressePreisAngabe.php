<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

class AdressePreisAngabe
{
    protected const ANGABEN = [
        0 => 'Standard',
        1 => 'Netto',
        2 => 'Brutto',
    ];

    protected int $angabe;

    public function __construct(int $angabe = 0)
    {
        $this->angabe = $angabe;
    }

    public function getAngabe(): int
    {
        return $this->angabe;
    }

    public function setAngabe(int $angabe): void
    {
        $this->angabe = $angabe;
    }


    public function getBeschreibung(): string
    {
        return self::ANGABEN[$this->getAngabe()] ?? '';
    }

    public function __toString(): string
    {
        return $this->getBeschreibung();
    }

    public function toArray(): array
    {
        return [
            'AdressePreisAngabe' => $this->getAngabe(),
        ];
    }
}
