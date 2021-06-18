<?php declare(strict_types=1);

namespace ArrobaIt\Tests;

use ArrobaIt\MoConnectApi\Client;
use Dotenv\Dotenv;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    protected Client $client;

    protected string $nameOfBodyMockFile = '';

    public function setUp(): void
    {
        $this->createMockClient();
    }

    protected function createMockClient(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        $mockResponse = file_get_contents(__DIR__ . '/mock/bodies/' . $this->nameOfBodyMockFile . '.json');

        $mock = new MockHandler([
            new Response(200, [], $mockResponse),
        ]);

        $handlerStack = HandlerStack::create($mock);

        $this->client = new Client($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['COMPANY_ID'], $handlerStack);
    }

}

