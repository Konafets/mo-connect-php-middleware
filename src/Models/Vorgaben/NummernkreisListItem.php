<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class NummernkreisListItem
{
    use ResponseTrait;

    protected NummernkreisIdents $nkIdent;

    protected string $gruppe = '';

    protected string $bereich = '';

    /**
     * Beispielwert, ist zeitpunktabhängig
     *
     * @var string
     * @deprecated
     */
    protected string $aktuell = '';

    /**
     * Beispielwert, ist zeitpunktabhängig
     *
     * @var string
     */
    protected string $nachfolger = '';

    public function __construct(NummernkreisIdents $nkIdent, string $gruppe, string $bereich, string $aktuell, string $nachfolger)
    {
        $this->nkIdent = $nkIdent;
        $this->gruppe = $gruppe;
        $this->bereich = $bereich;
        $this->aktuell = $aktuell;
        $this->nachfolger = $nachfolger;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            new NummernkreisIdents($response->NKIdent),
            $response->Gruppe,
            $response->Bereich,
            $response->Aktuell,
            $response->Nachfolger
        );
    }

    public function getNkIdent(): int
    {
        return $this->nkIdent->getId();
    }

    public function setNkIdent(int $id): void
    {
        $this->nkIdent->setId($id);
    }

    public function getGruppe(): string
    {
        return $this->gruppe;
    }

    public function setGruppe(string $gruppe): void
    {
        $this->gruppe = $gruppe;
    }

    public function getBereich(): string
    {
        return $this->bereich;
    }

    public function setBereich(string $bereich): void
    {
        $this->bereich = $bereich;
    }

    public function getAktuell(): string
    {
        return $this->aktuell;
    }

    public function setAktuell(string $aktuell): void
    {
        $this->aktuell = $aktuell;
    }

    public function getNachfolger(): string
    {
        return $this->nachfolger;
    }

    public function setNachfolger(string $nachfolger): void
    {
        $this->nachfolger = $nachfolger;
    }
}
