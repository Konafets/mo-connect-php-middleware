<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\NummernkreisListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\NummernkreisListService;
use ArrobaIt\Tests\BaseTest;

final class NummernkreisListTest extends BaseTest
{
    protected NummernkreisListService $service;

    protected string $nameOfBodyMockFile = 'Vorgaben/nummernkreisListResponse';

    protected NummernkreisListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new NummernkreisListService($this->client);
        $this->result = $this->service->nummernkreisList();
    }

    /**
     * @test
     */
    public function responseContainsTwentyItems(): void
    {
        self::assertCount(20, $this->result);
    }

    /**
     * @test
     */
    public function responseContainsNkIdent(): void
    {
        self::assertEquals(8, $this->result[0]->getNkIdent());
    }

    /**
     * @test
     */
    public function responseContainsGruppe(): void
    {
        self::assertEquals('Stammdaten', $this->result[0]->getGruppe());
    }

    /**
     * @test
     */
    public function responseContainsBereich(): void
    {
        self::assertEquals('Adresse', $this->result[0]->getBereich());
    }

    /**
     * @test
     */
    public function responseContainsAktuell(): void
    {
        self::assertEquals('ADR-000000', $this->result[0]->getAktuell());
    }

    /**
     * @test
     */
    public function responseContainsNachfolger(): void
    {
        self::assertEquals('ADR-000001', $this->result[0]->getNachfolger());
    }
}

