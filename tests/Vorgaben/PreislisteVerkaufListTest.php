<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\VerkaufpreislisteListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\PreislisteVerkaufListService;
use ArrobaIt\Tests\BaseTest;

final class PreislisteVerkaufListTest extends BaseTest
{
    protected PreislisteVerkaufListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/preislisteVerkaufListResponse',
    ];

    protected VerkaufpreislisteListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new PreislisteVerkaufListService($this->client);
        $this->result = $this->service->preislisteVerkaufList();
    }

    /**
     * @test
     */
    public function responseContainsFourItems(): void
    {
        self::assertCount(4, $this->result);
    }

    /**
     * @test
     */
    public function responseContainsID(): void
    {
        self::assertEquals(42, $this->result[0]->getVkPreislisteId());
        self::assertEquals(5, $this->result[1]->getVkPreislisteId());
    }

    /**
     * @test
     */
    public function responseContainsBezeichnung(): void
    {
        self::assertEquals('Foo', $this->result[0]->getBezeichnung());
        self::assertEquals('Bar', $this->result[1]->getBezeichnung());
    }

    /**
     * @test
     */
    public function responseContainsBeschreibung(): void
    {
        self::assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At in tellus integer feugiat scelerisque. Cras fermentum odio eu feugiat pretium nibh ipsum consequat. In nibh mauris cursus mattis. Elit at imperdiet dui accumsan sit amet nulla facilisi. Vel orci porta non pulvinar neque laoreet suspendisse. Aliquam ut porttitor leo a diam sollicitudin. Tincidunt tortor aliquam nulla facilisi. Mauris augue neque gravida in fermentum et. Velit egestas dui id ornare arcu.', $this->result[0]->getBeschreibung());
        self::assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At in tellus integer feugiat scelerisque. Cras fermentum odio eu feugiat pretium nibh ipsum consequat. In nibh mauris cursus mattis. Elit at imperdiet dui accumsan sit amet nulla facilisi. Vel orci porta non pulvinar neque laoreet suspendisse. Aliquam ut porttitor leo a diam sollicitudin. Tincidunt tortor aliquam nulla facilisi. Mauris augue neque gravida in fermentum et. Velit egestas dui id ornare arcu.', $this->result[1]->getBeschreibung());
    }

    /**
     * @test
     */
    public function responseContainsStandard(): void
    {
        self::assertTrue($this->result[0]->isStandard());
        self::assertFalse($this->result[1]->isStandard());
    }

    /**
     * @test
     */
    public function responseContainsBerechnungArt(): void
    {
        self::assertEquals(1, $this->result[0]->getBerechnungArt());
        self::assertEquals('Netto', $this->result[0]->getBerechnungArtBeschreibung());
        self::assertEquals(2, $this->result[1]->getBerechnungArt());
        self::assertEquals('Brutto', $this->result[1]->getBerechnungArtBeschreibung());
    }

    /**
     * @test
     */
    public function responseContainsMargeArt(): void
    {
        self::assertEquals(1, $this->result[0]->getMargeArt());
        self::assertEquals('Betrag', $this->result[0]->getMargeArtBeschreibung());
        self::assertEquals(2, $this->result[1]->getMargeArt());
        self::assertEquals('Prozent', $this->result[1]->getMargeArtBeschreibung());
        self::assertEquals('VKGesamt', $this->result[2]->getMargeArtBeschreibung());

        self::assertEquals('', $this->result[3]->getMargeArtBeschreibung());
    }
}

