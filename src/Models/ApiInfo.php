<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models;

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

    /**
     * @return string
     */
    public function getAppName(): string
    {
        return $this->appName;
    }

    /**
     * @param string $appName
     */
    public function setAppName(string $appName): void
    {
        $this->appName = $appName;
    }

    /**
     * @return string
     */
    public function getHomepage(): string
    {
        return $this->homepage;
    }

    /**
     * @param string $homepage
     */
    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getMajorVersion(): int
    {
        return $this->majorVersion;
    }

    /**
     * @param int $majorVersion
     */
    public function setMajorVersion(int $majorVersion): void
    {
        $this->majorVersion = $majorVersion;
    }

    /**
     * @return int
     */
    public function getMinorVersion(): int
    {
        return $this->minorVersion;
    }

    /**
     * @param int $minorVersion
     */
    public function setMinorVersion(int $minorVersion): void
    {
        $this->minorVersion = $minorVersion;
    }

    /**
     * @return int
     */
    public function getBugVersion(): int
    {
        return $this->bugVersion;
    }

    /**
     * @param int $bugVersion
     */
    public function setBugVersion(int $bugVersion): void
    {
        $this->bugVersion = $bugVersion;
    }

    /**
     * @return int
     */
    public function getBuild(): int
    {
        return $this->build;
    }

    /**
     * @param int $build
     */
    public function setBuild(int $build): void
    {
        $this->build = $build;
    }

    /**
     * @return int
     */
    public function getApiSchemaVersion(): int
    {
        return $this->apiSchemaVersion;
    }

    /**
     * @param int $apiSchemaVersion
     */
    public function setApiSchemaVersion(int $apiSchemaVersion): void
    {
        $this->apiSchemaVersion = $apiSchemaVersion;
    }

    /**
     * @return string
     */
    public function getCopyright(): string
    {
        return $this->copyright;
    }

    /**
     * @param string $copyright
     */
    public function setCopyright(string $copyright): void
    {
        $this->copyright = $copyright;
    }

    /**
     * @return bool
     */
    public function isNewVersion(): bool
    {
        return $this->newVersion;
    }

    /**
     * @param bool $newVersion
     */
    public function setNewVersion(bool $newVersion): void
    {
        $this->newVersion = $newVersion;
    }
}
