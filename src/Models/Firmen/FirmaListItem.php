<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Firmen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;

class FirmaListItem
{
    use ResponseTrait;

    /**
     * @var string
     * @see Firma_ID
     */
    protected string $id = '';

    /**
     * @var string
     * @see Bezeichnung
     */
    protected string $bezeichnung = '';

    /**
     * @var string
     * @see Zusatz
     */
    protected string $zusatz = '';

    public function __construct(string $id, string $bezeichnung, string $zusatz)
    {
        $this->id = $id;
        $this->bezeichnung = $bezeichnung;
        $this->zusatz = $zusatz;
    }

    public static function fromResponse(\stdClass $response): self
    {
        self::$content = $response;

        $firmaList = $response->FirmaListItem;

        return new self(
            $firmaList[0]->Firma_ID,
            $firmaList[0]->Bezeichnung,
            $firmaList[0]->Zusatz
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getBezeichnung(): string
    {
        return $this->bezeichnung;
    }

    public function setBezeichnung(string $bezeichnung): void
    {
        $this->bezeichnung = $bezeichnung;
    }

    public function getZusatz(): string
    {
        return $this->zusatz;
    }

    public function setZusatz(string $zusatz): void
    {
        $this->zusatz = $zusatz;
    }
}
