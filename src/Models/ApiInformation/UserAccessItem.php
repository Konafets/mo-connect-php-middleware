<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\ApiInformation;

class UserAccessItem
{

    protected string $moduleId = '';

    protected string $moduleName = '';

    protected bool $zugriff = false;

    protected bool $anlegen = false;

    protected bool $aendern = false;

    protected bool $loeschen = false;

    public function __construct(string $moduleId, string $moduleName, bool $zugriff, bool $anlegen, bool $aendern, bool $loeschen)
    {
        $this->moduleId = $moduleId;
        $this->moduleName = $moduleName;
        $this->zugriff = $zugriff;
        $this->anlegen = $anlegen;
        $this->aendern = $aendern;
        $this->loeschen = $loeschen;
    }

    public function getModuleId(): string
    {
        return $this->moduleId;
    }

    public function setModuleId(string $moduleId): void
    {
        $this->moduleId = $moduleId;
    }

    public function getModuleName(): string
    {
        return $this->moduleName;
    }

    public function setModuleName(string $moduleName): void
    {
        $this->moduleName = $moduleName;
    }

    public function isZugriff(): bool
    {
        return $this->zugriff;
    }

    public function setZugriff(bool $zugriff): void
    {
        $this->zugriff = $zugriff;
    }

    public function isAnlegen(): bool
    {
        return $this->anlegen;
    }

    public function setAnlegen(bool $anlegen): void
    {
        $this->anlegen = $anlegen;
    }

    public function isAendern(): bool
    {
        return $this->aendern;
    }

    public function setAendern(bool $aendern): void
    {
        $this->aendern = $aendern;
    }

    public function isLoeschen(): bool
    {
        return $this->loeschen;
    }

    public function setLoeschen(bool $loeschen): void
    {
        $this->loeschen = $loeschen;
    }
}
