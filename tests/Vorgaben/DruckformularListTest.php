<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\DruckFormularListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\DruckformularListService;
use ArrobaIt\Tests\BaseTest;

final class DruckformularListTest extends BaseTest
{
    protected DruckformularListService $service;

    protected string $nameOfBodyMockFile = 'Vorgaben/druckformularListResponse';

    protected DruckFormularListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new DruckformularListService($this->client);
        $this->result = $this->service->druckformularList();
    }

    /**
     * @test
     */
    public function resultContainsName(): void
    {
        self::assertEquals('Auftragsformular universal A4 hoch', $this->result[0]->getDruckFormularName());
        self::assertEquals('Auftragsformular universal A4 hoch, KEA_MOSS', $this->result[1]->getDruckFormularName());
        self::assertEquals('Bestellformular universal A4 hoch', $this->result[2]->getDruckFormularName());
        self::assertEquals('Anschreiben SEPA Mitteilung', $this->result[3]->getDruckFormularName());
        self::assertEquals('Einmallastschrift', $this->result[4]->getDruckFormularName());
        self::assertEquals('Lastschriftsmandat, abweichender Schuldner', $this->result[5]->getDruckFormularName());
        self::assertEquals('Wiederkehrenden Lastschrift', $this->result[6]->getDruckFormularName());
    }

    /**
     * @test
     */
    public function resultContainsGroup(): void
    {
        self::assertEquals(1008, $this->result[0]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1008, $this->result[1]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1014, $this->result[2]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1017, $this->result[3]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1017, $this->result[4]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1017, $this->result[5]->getDruckFormularGruppe()->getGroup());
        self::assertEquals(1017, $this->result[6]->getDruckFormularGruppe()->getGroup());
    }
}

