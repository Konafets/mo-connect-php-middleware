<?php declare(strict_types=1);

namespace ArrobaIt\Tests;

use ArrobaIt\MoConnectApi\Client;
use ArrobaIt\MoConnectApi\Services\ApiInfoService;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use stdClass;

final class ClientTest extends TestCase
{
    protected Client $client;

    public function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $credentials = [
            'username' => $_ENV['USERNAME'],
            'password' => $_ENV['PASSWORD'],
            'company' => $_ENV['COMPANY_ID'],
            'host' => $_ENV['API_HOST'],
            'port' => $_ENV['API_PORT'],
        ];

        $this->client = Client::fromCredentials($credentials);
    }

    /**
     * @test
     */
    public function hasContentAfterCallingService(): void
    {
        $service = new ApiInfoService($this->client);
        $response = $service->apiInfoGet();

        self::assertTrue($response->hasContent());
    }

    /**
     * @test
     */
    public function hasStatusAfterCallingService(): void
    {
        $service = new ApiInfoService($this->client);
        $response = $service->apiInfoGet();

        self::assertFalse($response->hasStatus());
    }

    /**
     * @throws \JsonException
     * @test
     */
    public function fooBar(): void
    {
        $request = [
            'apiInfoGet' => '',
        ];

        $foo = $this->client->send($request);
        self::assertInstanceOf(stdClass::class, $foo);
    }
}

