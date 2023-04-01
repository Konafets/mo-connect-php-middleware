<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\SteuersatzListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\SteuersatzListService;
use ArrobaIt\Tests\BaseTest;

final class SteuersatzListTest extends BaseTest
{
    protected SteuersatzListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/steuersatzListResponse',
    ];

    protected SteuersatzListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new SteuersatzListService($this->client);
        $this->result = $this->service->steuersatzList();
    }

    /**
     * @test
     */
    public function responseContainsFourtyItems(): void
    {
        self::assertCount(40, $this->result);
    }

    /**
     * @test
     */
    public function responseContainsName(): void
    {
        self::assertEquals('igE16', $this->result[0]->getName());
    }

    /**
     * @test
     */
    public function responseContainsBeschreibung(): void
    {
        self::assertEquals('innerg. Erwerb 16% (USt- und VSt)', $this->result[0]->getBeschreibung());
    }

    /**
     * @test
     */
    public function responseContainsSteuersatz(): void
    {
        self::assertEquals('16,00', $this->result[0]->getSteuersatz());
    }

    /**
     * @test
     */
    public function responseContainsIsGeperrt(): void
    {
        self::assertFalse($this->result[0]->isGesperrt());
    }
}

