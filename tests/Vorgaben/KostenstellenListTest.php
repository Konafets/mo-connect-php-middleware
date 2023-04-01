<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\KostenstelleListItemCollection;
use ArrobaIt\MoConnectApi\Services\Vorgaben\KostenstellenListService;
use ArrobaIt\Tests\BaseTest;

final class KostenstellenListTest extends BaseTest
{
    protected KostenstellenListService $service;

    protected array $mockResponseBodies = [
        'Vorgaben/kostenstellenListResponse',
    ];

    protected KostenstelleListItemCollection $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new KostenstellenListService($this->client);
        $this->result = $this->service->kostenstellenList();
    }

    /**
     * @test
     */
    public function resultContainsThreeKostenstellen(): void
    {
        self::assertEquals('Foo', $this->result[0]->getName());
        self::assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. At in tellus integer feugiat scelerisque.', $this->result[0]->getBeschreibung());
        self::assertEquals('Cras fermentum odio eu feugiat pretium nibh ipsum consequat. In nibh mauris cursus mattis. Elit at imperdiet dui accumsan sit amet nulla facilisi. Vel orci porta non pulvinar neque laoreet suspendisse. Aliquam ut porttitor leo a diam sollicitudin. Tincidunt tortor aliquam nulla facilisi. Mauris augue neque gravida in fermentum et. Velit egestas dui id ornare arcu.', $this->result[0]->getBemerkung());

        self::assertEquals('Bar', $this->result[1]->getName());
        self::assertEquals('Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte.', $this->result[1]->getBeschreibung());
        self::assertEquals('Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien.', $this->result[1]->getBemerkung());

        self::assertEquals('Baz', $this->result[2]->getName());
        self::assertEquals('Eine wunderbare Heiterkeit hat meine ganze Seele eingenommen, gleich den süßen Frühlingsmorgen, die ich mit ganzem Herzen genieße.', $this->result[2]->getBeschreibung());
        self::assertEquals('Ich bin allein und freue mich meines Lebens in dieser Gegend, die für solche Seelen geschaffen ist wie die meine. Ich bin so glücklich, mein Bester, so ganz in dem Gefühle von ruhigem Dasein versunken, daß meine Kunst darunter leidet.', $this->result[2]->getBemerkung());
    }
}

