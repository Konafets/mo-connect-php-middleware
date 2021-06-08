<?php declare(strict_types=1);

namespace ArrobaIt\Tests;

use GuzzleHttp\Client as BaseClient;
use ArrobaIt\MoConnectApi\Client;
use ArrobaIt\MoConnectApi\Models\ApiInformation\ApiInfo;
use ArrobaIt\MoConnectApi\Services\ApiInfoService;
use Dotenv\Dotenv;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class ApiInfoTest extends TestCase
{
    protected Client $client;

    protected ApiInfoService $service;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $mockResponse = file_get_contents(__DIR__ . '/mock/bodies/apiInformation.json');

        $mock = new MockHandler([
            new Response(200, [], $mockResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['COMPANY_ID'], $handlerStack);
        $this->service = new ApiInfoService($client);
    }

    /**
     * @throws \JsonException
     */
    public function testResultOfApiInfoIsModel(): void
    {
        $apiInfo = $this->service->apiInfoGet();
        self::assertInstanceOf(ApiInfo::class, $apiInfo);
    }

    /**
     * @test
     */
    public function apiInfoReturnsAppName(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame('MonKey Office Connect', $info->getAppName());
    }

    /**
     * @test
     */
    public function apiInfoReturnsHomepage(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame('www.monkey-office.de', $info->getHomepage());
    }

    /**
     * @test
     */
    public function apiInfoReturnsEmail(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame('info@monkey-office.de', $info->getEmail());
    }

    /**
     * @test
     */
    public function apiInfoReturnsMajorVersion(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame(18, $info->getMajorVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsMinorVersion(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame(1, $info->getMinorVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsBugVersion(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame(0, $info->getBugVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsBuild(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame(4, $info->getBuild());
    }

    /**
     * @test
     */
    public function apiInfoReturnsApiSchemaVersion(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame(91, $info->getApiSchemaVersion());
    }

    /**
     * @test
     */
    public function apiInfoReturnsCopyright(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertSame('© 1997-2020 ProSaldo GmbH', $info->getCopyright());
    }

    /**
     * @test
     */
    public function apiInfoReturnsNewVersion(): void
    {
        $info = $this->service->apiInfoGet();
        self::assertTrue($info->isNewVersion());
    }
}

