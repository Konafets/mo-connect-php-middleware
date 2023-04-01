<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\WaehrungListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\WaehrungListService;
use ArrobaIt\Tests\BaseTest;

final class WaehrungListTest extends BaseTest
{
    protected WaehrungListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/waehrungListResponse',
    ];

    protected WaehrungListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new WaehrungListService($this->client);
        $this->result = $this->service->waehrungList();
    }

    /**
     * @test
     */
    public function responseContainsThreeItems(): void
    {
        self::assertCount(3, $this->result);
    }

    /**
     * @test
     */
    public function responseContainsName(): void
    {
        self::assertEquals('Schweizer Franken', $this->result[0]->getName());
    }

    /**
     * @test
     */
    public function responseContainsIsoCode(): void
    {
        self::assertEquals('CHF', $this->result[0]->getIsocode());
    }

    /**
     * @test
     */
    public function responseContainsKurs(): void
    {
        self::assertEquals('1,55210000', $this->result[0]->getKurs());
    }
}

