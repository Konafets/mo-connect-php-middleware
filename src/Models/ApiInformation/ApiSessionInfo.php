<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\ApiInformation;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

class ApiSessionInfo
{
    use ResponseTrait;

    protected string $appDatenBank = '';

    protected int $appDbSchemaVersion;

    protected string $firmaId = '';

    protected string $benutzerId = '';

    protected string $userName = '';

    /**
     * @var UserAccessItem[]
     * @since Version 17.2
     */
    protected array $userAccessItemList = [];

    public function __construct(
        string $appDatenBank,
        int $appDbSchemaVersion,
        string $firmaId,
        string $benutzerId,
        string $userName,
        stdClass $userAccessItemList
    ) {
        $this->appDatenBank = $appDatenBank;
        $this->appDbSchemaVersion = $appDbSchemaVersion;
        $this->firmaId = $firmaId;
        $this->benutzerId = $benutzerId;
        $this->userName = $userName;
        $this->userAccessItemList = array_map(function ($item) {
            return new UserAccessItem($item->Modul_ID, $item->ModulName, $item->Zugriff, $item->Anlegen, $item->Aendern, $item->Loeschen);
        }, $userAccessItemList->UserAccessItem);
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        $apisessionInfoItem = $response->apisessionInfoItem;

        return new self(
            $apisessionInfoItem->App_Datenbank,
            $apisessionInfoItem->App_DBSchemaVersion,
            $apisessionInfoItem->Firma_ID,
            $apisessionInfoItem->Benutzer_ID,
            $apisessionInfoItem->User_Name,
            $apisessionInfoItem->UserAccessItemList
        );
    }

    public function getAppDatenBank(): string
    {
        return $this->appDatenBank;
    }

    public function setAppDatenBank(string $appDatenBank): void
    {
        $this->appDatenBank = $appDatenBank;
    }

    public function getAppDbSchemaVersion(): int
    {
        return $this->appDbSchemaVersion;
    }

    public function setAppDbSchemaVersion(int $appDbSchemaVersion): void
    {
        $this->appDbSchemaVersion = $appDbSchemaVersion;
    }

    public function getFirmaId(): string
    {
        return $this->firmaId;
    }

    public function setFirmaId(string $firmaId): void
    {
        $this->firmaId = $firmaId;
    }

    public function getBenutzerId(): string
    {
        return $this->benutzerId;
    }

    public function setBenutzerId(string $benutzerId): void
    {
        $this->benutzerId = $benutzerId;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getUserAccessItemList(): array
    {
        return $this->userAccessItemList;
    }

    public function setUserAccessItemList(array $userAccessItemList): void
    {
        $this->userAccessItemList = $userAccessItemList;
    }
}
