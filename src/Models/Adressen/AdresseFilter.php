<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class AdresseFilter
{
    use ResponseTrait;

    protected string $suchtext = '';

    protected string $matchcode = '';

    protected string $adresseKategorie = '';

    protected AdresseStatus $lieferantenStatus;

    protected AdresseStatus $kundenStatus;

    public function __construct(
        string $suchtext,
        string $matchcode,
        string $adresseKategorie,
        AdresseStatus $lieferantenStatus,
        AdresseStatus $kundenStatus
    ) {
        $this->suchtext = $suchtext;
        $this->matchcode = $matchcode;
        $this->adresseKategorie = $adresseKategorie;
        $this->lieferantenStatus = $lieferantenStatus;
        $this->kundenStatus = $kundenStatus;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self(
            $response->Suchtext,
            $response->Matchcode,
            $response->AdresseKategorie,
            new AdresseStatus((int)$response->LieferantenStatus),
            new AdresseStatus((int)$response->KundenStatus),
        );
    }

    public function getSuchtext(): string
    {
        return $this->suchtext;
    }

    public function setSuchtext(string $suchtext): void
    {
        $this->suchtext = $suchtext;
    }

    public function getMatchcode(): string
    {
        return $this->matchcode;
    }

    public function setMatchcode(string $matchcode): void
    {
        $this->matchcode = $matchcode;
    }

    public function getAdresseKategorie(): string
    {
        return $this->adresseKategorie;
    }

    public function setAdresseKategorie(string $adresseKategorie): void
    {
        $this->adresseKategorie = $adresseKategorie;
    }

    public function getLieferantenStatus(): int
    {
        return $this->lieferantenStatus->getStatus();
    }

    public function setLieferantenStatus(int $lieferantenStatus): void
    {
        $this->lieferantenStatus->setStatus($lieferantenStatus);
    }

    public function getKundenStatus(): int
    {
        return $this->kundenStatus->getStatus();
    }

    public function setKundenStatus(int $kundenStatus): void
    {
        $this->kundenStatus->setStatus($kundenStatus);
    }

    public function getLieferantenStatusBeschreibung(): string
    {
        return (string) $this->lieferantenStatus;
    }

    public function getKundenStatusBeschreibung(): string
    {
        return (string) $this->kundenStatus;
    }
}
