<?php declare(strict_types=1);

namespace ArrobaIt\Tests\ApiInformation;

use ArrobaIt\MoConnectApi\Models\ApiInformation\ApiInfo;
use ArrobaIt\MoConnectApi\Services\ApiInfoService;
use ArrobaIt\Tests\BaseTest;

final class ApiInfoTest extends BaseTest
{
    protected ApiInfoService $service;

    protected array $mockResponseBodies = [
        'ApiInformation/apiInformation',
    ];

    protected ApiInfo $apiInfo;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ApiInfoService($this->client);
        $this->apiInfo = $this->service->apiInfoGet();
    }

    /**
     * @throws \JsonException
     */
    public function testResultOfApiInfoIsModel(): void
    {
        self::assertInstanceOf(ApiInfo::class, $this->apiInfo);
    }

    /**
     * @test
     */
    public function apiInfoReturnsAppName(): void
    {
        self::assertSame('MonKey Office Connect', $this->apiInfo->getAppName());
    }

    /**
     * @test
     */
    public function apiInfoReturnsHomepage(): void
    {
        self::assertSame('www.monkey-office.de', $this->apiInfo->getHomepage());
    }

    /**
     * @test
     */
    public function apiInfoReturnsEmail(): void
    {
        self::assertSame('info@monkey-office.de', $this->apiInfo->getEmail());
    }

    /**
     * @test
     */
    public function apiInfoReturnsMajorVersion(): void
    {
        self::assertSame(18, $this->apiInfo->getMajorVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsMinorVersion(): void
    {
        self::assertSame(1, $this->apiInfo->getMinorVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsBugVersion(): void
    {
        self::assertSame(0, $this->apiInfo->getBugVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsBuild(): void
    {
        self::assertSame(4, $this->apiInfo->getBuild());
    }

    /**
     * @test
     */
    public function apiInfoReturnsApiSchemaVersion(): void
    {
        self::assertSame(91, $this->apiInfo->getApiSchemaVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsCopyright(): void
    {
        self::assertSame('© 1997-2020 ProSaldo GmbH', $this->apiInfo->getCopyright());
    }

    /**
     * @test
     */
    public function apiInfoReturnsNewVersion(): void
    {
        self::assertTrue($this->apiInfo->isNewVersion());
    }
}

