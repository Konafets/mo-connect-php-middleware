<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\ZahlungsBedingungEinkaufListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\ZahlungsbedingungEinkaufListService;
use ArrobaIt\Tests\BaseTest;

final class ZahlungsbedingungEinkaufListTest extends BaseTest
{
    protected ZahlungsbedingungEinkaufListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/zahlungsbedingungEinkaufListResponse',
    ];

    protected ZahlungsBedingungEinkaufListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ZahlungsbedingungEinkaufListService($this->client);
        $this->result = $this->service->zahlungsbedingungEinkaufList();
    }

    /**
     * @test
     */
    public function responseContainsBezeichnung(): void
    {
        self::assertEquals('Foo', $this->result[0]->getBezeichnung());
    }

    /**
     * @test
     */
    public function responseContainsZahlungsart(): void
    {
        self::assertEquals(0, $this->result[0]->getZahlungsart());
    }

    /**
     * @test
     */
    public function responseContainsZahlungsartBeschreibung(): void
    {
        self::assertEquals('Keine', $this->result[0]->getZahlungsartBeschreibung());
        self::assertEquals('Bar', $this->result[1]->getZahlungsartBeschreibung());
    }

    /**
     * @test
     */
    public function responseContainsTageNetto(): void
    {
        self::assertEquals(10, $this->result[0]->getTageNetto());
    }

    /**
     * @test
     */
    public function responseContainsTageSkonto(): void
    {
        self::assertEquals(5, $this->result[0]->getTageSkonto());
    }

    /**
     * @test
     */
    public function responseContainsProzentSkonto(): void
    {
        self::assertEquals('0,5', $this->result[0]->getProzentSkonto());
    }
}

