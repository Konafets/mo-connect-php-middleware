<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularFilter;
use ArrobaIt\MoConnectApi\Services\Vorgaben\DruckformularFilterTemplateService;
use ArrobaIt\Tests\BaseTest;

final class DruckformularFilterTemplateTest extends BaseTest
{
    protected DruckformularFilterTemplateService $service;

    protected string $nameOfBodyMockFile = 'Vorgaben/druckformularFilterTemplateResponse';

    protected DruckformularFilter $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new DruckformularFilterTemplateService($this->client);
        $this->result = $this->service->druckformularFilterTemplate();
    }

    /**
     * @test
     */
    public function resultContainsSuchtext(): void
    {
        self::assertEquals('FooBarBaz', $this->result->getSuchtext());
    }

    /**
     * @test
     */
    public function resultContainsGruppe(): void
    {
        self::assertEquals(42, $this->result->getDruckFormularGruppe());
    }
}

