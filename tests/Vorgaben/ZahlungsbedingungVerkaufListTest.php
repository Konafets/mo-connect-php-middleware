<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\ZahlungsBedingungVerkaufListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\ZahlungsbedingungVerkaufListService;
use ArrobaIt\Tests\BaseTest;

final class ZahlungsbedingungVerkaufListTest extends BaseTest
{
    protected ZahlungsbedingungVerkaufListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/zahlungsbedingungVerkaufListResponse',
    ];

    protected ZahlungsBedingungVerkaufListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ZahlungsbedingungVerkaufListService($this->client);
        $this->result = $this->service->zahlungsbedingungVerkaufList();
    }

    /**
     * @test
     */
    public function responseContainsBezeichnung(): void
    {
        self::assertEquals('100% Vorkasse', $this->result[0]->getBezeichnung());
    }

    /**
     * @test
     */
    public function responseContainsZahlungsart(): void
    {
        self::assertEquals(4, $this->result[0]->getZahlungsart());
    }

    /**
     * @test
     */
    public function responseContainsZahlungsartBeschreibung(): void
    {
        self::assertEquals('Überweisung', $this->result[0]->getZahlungsartBeschreibung());
    }

    /**
     * @test
     */
    public function responseContainsTageNetto(): void
    {
        self::assertEquals(0, $this->result[0]->getTageNetto());
    }

    /**
     * @test
     */
    public function responseContainsTageSkonto(): void
    {
        self::assertEquals(0, $this->result[0]->getTageSkonto());
    }

    /**
     * @test
     */
    public function responseContainsProzentSkonto(): void
    {
        self::assertEquals('0,00', $this->result[0]->getProzentSkonto());
    }

    /**
     * @test
     */
    public function responseContainsisNichtMahnen(): void
    {
        self::assertFalse($this->result[0]->isNichtMahnen());
    }
}

