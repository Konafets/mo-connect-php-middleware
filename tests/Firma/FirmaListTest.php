<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Firma;

use ArrobaIt\MoConnectApi\Models\Firmen\FirmaListItems;
use ArrobaIt\MoConnectApi\Services\FirmaListService;
use ArrobaIt\Tests\BaseTest;

final class FirmaListTest extends BaseTest
{
    protected FirmaListService $service;

    protected array $mockReponseBodies = [
        'Firma/firmaListResponse'
    ];

    protected FirmaListItems $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new FirmaListService($this->client);
        $this->result = $this->service->firmaList();
    }

    /**
     * @test
     */
    public function firmaListReturnsCorrectAmountOfCompanies(): void
    {
        self::assertCount(2, $this->result->getFirmaListItems());
    }
}

