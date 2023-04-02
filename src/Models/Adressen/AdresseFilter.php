<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen;

use ArrobaIt\MoConnectApi\Models\Enums\AdresseStatusEnum;
use stdClass;

class AdresseFilter
{
    protected string $suchtext = '';

    protected string $matchcode = '';

    protected string $adresseKategorie = '';

    protected AdresseStatusEnum $lieferantenStatus;

    protected AdresseStatusEnum $kundenStatus;

    public function __construct(
        string $suchtext = '',
        string $matchcode = '',
        string $adresseKategorie = '',
        AdresseStatusEnum $lieferantenStatus = AdresseStatusEnum::OHNE_STATUS,
        AdresseStatusEnum $kundenStatus = AdresseStatusEnum::OHNE_STATUS
    ) {
        $this->suchtext = $suchtext;
        $this->matchcode = $matchcode;
        $this->adresseKategorie = $adresseKategorie;
        $this->lieferantenStatus = $lieferantenStatus;
        $this->kundenStatus = $kundenStatus;
    }

    public static function fromResponse(stdClass $response): self
    {
        return new self(
            $response->Suchtext,
            $response->Matchcode,
            $response->AdresseKategorie,
            AdresseStatusEnum::from((int) $response->LieferantenStatus),
            AdresseStatusEnum::from((int) $response->KundenStatus),
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
        return $this->lieferantenStatus->value;
    }

    public function setLieferantenStatus(int $lieferantenStatus): void
    {
        $this->lieferantenStatus = AdresseStatusEnum::from($lieferantenStatus);
    }

    public function getKundenStatus(): int
    {
        return $this->kundenStatus->value;
    }

    public function setKundenStatus(int $kundenStatus): void
    {
        $this->kundenStatus = AdresseStatusEnum::from($kundenStatus);
    }

    public function getLieferantenStatusBeschreibung(): string
    {
        return $this->lieferantenStatus->description();
    }

    public function getKundenStatusBeschreibung(): string
    {
        return $this->kundenStatus->description();
    }

    public function __toArray(): array
    {
        return [
            'Suchtext' => $this->getSuchtext(),
            'Matchcode' => $this->getMatchcode(),
            'AdresseKategorie' => $this->getAdresseKategorie(),
            'LieferantenStatus' => $this->getLieferantenStatus(),
            'KundenStatus' => $this->getKundenStatus(),
        ];
    }
}
