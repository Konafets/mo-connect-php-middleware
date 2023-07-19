<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\ApiInformation;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;

class ApiInfo
{
    use ResponseTrait;

    protected string $appName = '';

    protected string $homepage = '';

    protected string $email = '';

    protected int $majorVersion;

    protected int $minorVersion;

    protected int $bugVersion;

    protected int $build;

    protected int $apiSchemaVersion;

    protected string $copyright = '';

    protected bool $newVersion = false;

    public static function fromResponse(\stdClass $response): self
    {
        self::$content = $response;

        $apiInfoItem = $response->apiInfoItem;

        $name = $apiInfoItem->App_Name;
        $homepage = $apiInfoItem->App_Homepage;
        $email = $apiInfoItem->App_Email;
        $majorVersion = $apiInfoItem->App_MajorVersion;
        $minorVersion = $apiInfoItem->App_MinorVersion;
        $bugVersion = $apiInfoItem->App_BugVersion;
        $build = $apiInfoItem->App_Build;
        $apiSchemaVersion = $apiInfoItem->App_APISchemaVersion;
        $copyright = $apiInfoItem->App_CopyRight;
        $newVersion = $apiInfoItem->App_NewVersion;

        return new self(
            $name,
            $homepage,
            $email,
            $majorVersion,
            $minorVersion,
            $bugVersion,
            $build,
            $apiSchemaVersion,
            $copyright,
            $newVersion
        );
    }

    public static function null(): self
    {
        return new self(
            '',
            '',
            '',
            0,
            0,
            0,
            0,
            0,
            '',
            false,
        );
    }

    public function __construct(
        string $appName,
        string $homepage,
        string $email,
        int $majorVersion,
        int $minorVersion,
        int $bugVersion,
        int $build,
        int $apiSchemaVersion,
        string $copyright,
        bool $newVersion
    ) {
        $this->appName = $appName;
        $this->homepage = $homepage;
        $this->email = $email;
        $this->majorVersion = $majorVersion;
        $this->minorVersion = $minorVersion;
        $this->bugVersion = $bugVersion;
        $this->build = $build;
        $this->apiSchemaVersion = $apiSchemaVersion;
        $this->copyright = $copyright;
        $this->newVersion = $newVersion;
    }

    public function getAppName(): string
    {
        return $this->appName;
    }

    public function setAppName(string $appName): void
    {
        $this->appName = $appName;
    }

    public function getHomepage(): string
    {
        return $this->homepage;
    }

    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMajorVersion(): int
    {
        return $this->majorVersion;
    }

    public function setMajorVersion(int $majorVersion): void
    {
        $this->majorVersion = $majorVersion;
    }

    public function getMinorVersion(): int
    {
        return $this->minorVersion;
    }

    public function setMinorVersion(int $minorVersion): void
    {
        $this->minorVersion = $minorVersion;
    }

    public function getBugVersion(): int
    {
        return $this->bugVersion;
    }

    public function setBugVersion(int $bugVersion): void
    {
        $this->bugVersion = $bugVersion;
    }

    public function getBuild(): int
    {
        return $this->build;
    }

    public function setBuild(int $build): void
    {
        $this->build = $build;
    }

    public function getApiSchemaVersion(): int
    {
        return $this->apiSchemaVersion;
    }

    public function setApiSchemaVersion(int $apiSchemaVersion): void
    {
        $this->apiSchemaVersion = $apiSchemaVersion;
    }

    public function getCopyright(): string
    {
        return $this->copyright;
    }

    public function setCopyright(string $copyright): void
    {
        $this->copyright = $copyright;
    }

    public function isNewVersion(): bool
    {
        return $this->newVersion;
    }

    public function setNewVersion(bool $newVersion): void
    {
        $this->newVersion = $newVersion;
    }
}
