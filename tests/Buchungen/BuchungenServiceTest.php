<?php

declare(strict_types=1);

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungAddItem;
use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungFilter;
use ArrobaIt\MoConnectApi\Models\Buchungen\Collections\BuchungJournalItemListCollection;
use ArrobaIt\MoConnectApi\Models\Http\ReturnStatus;
use ArrobaIt\MoConnectApi\Services\Buchungen\BuchungenService;
use ArrobaIt\Tests\BaseTest;
use GuzzleHttp\Exception\GuzzleException;

class BuchungenServiceTest extends BaseTest
{

    protected BuchungenService $service;

    /**
     * @test
     */
    public function buchungFilterTemplate(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungenFilterTemplateResponse',
        ];

        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $buchungFilterTemplate = $this->service->buchungFilterTemplate();
        self::assertEquals('Foo', $buchungFilterTemplate->getSuchtext());
        self::assertEquals('2023-01-01', $buchungFilterTemplate->getDatumVon());
        self::assertEquals('2023-12-31', $buchungFilterTemplate->getDatumBis());
        self::assertEquals(4, $buchungFilterTemplate->getFestschreibeStatus());
        self::assertEquals('12345', $buchungFilterTemplate->getBelegNr());
        self::assertEquals(1200, $buchungFilterTemplate->getKonto());
        self::assertEquals(3, $buchungFilterTemplate->getKontoSoll());
        self::assertEquals(5, $buchungFilterTemplate->getKontoHaben());
    }

    /**
     * @test
     */
    public function getBuchungenListWithoutFilter(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungenListResponseWithoutFilter',
        ];

        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $buchungen = $this->service->buchungList();

        self::assertCount(1, $buchungen);

        self::assertEquals('4B1D754683FF2B7DB23598B64C18', $buchungen[0]->getBuchungId());
        self::assertEquals('2023-04-01', $buchungen[0]->getDatum());
        self::assertEquals('Zahlung, ReNr: 000001, IMPORTED_CUSTOMER1', $buchungen[0]->getText());
        self::assertEquals(1, $buchungen[0]->getStatus());
        self::assertEquals('357,00', $buchungen[0]->getSumme());
        self::assertEquals('357,00', $buchungen[0]->getSummeFw());
        self::assertEquals('000001', $buchungen[0]->getBelegNr());
    }

    /**
     * @test
     */
    public function getBuchungenListWithFilter(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungenListResponseWithFilter',
        ];

        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $filter = new BuchungFilter();
        $filter->setSuchtext('Foo');
        $buchungen = $this->service->buchungList($filter);

        self::assertCount(1, $buchungen);

        self::assertEquals('4B1D754683FF2B7DB23598B64C18', $buchungen[0]->getBuchungId());
        self::assertEquals('2023-04-01', $buchungen[0]->getDatum());
        self::assertEquals('Zahlung, ReNr: 000001, IMPORTED_CUSTOMER1', $buchungen[0]->getText());
        self::assertEquals(1, $buchungen[0]->getStatus());
        self::assertEquals('357,00', $buchungen[0]->getSumme());
        self::assertEquals('357,00', $buchungen[0]->getSummeFw());
        self::assertEquals('000001', $buchungen[0]->getBelegNr());
    }

    /**
     * @test
     */
    public function buchungGet(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungGetResponse',
        ];
        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $id = '4B1D754683FF2B7DB23598B64C18';
        $buchung = $this->service->buchungGet($id);

        self::assertEquals('4B1D754683FF2B7DB23598B64C18', $buchung->getBuchungId());
        self::assertEquals('2023-04-01', $buchung->getDatum());
        self::assertEquals('Zahlung, ReNr: 000001, IMPORTED_CUSTOMER1', $buchung->getText());
        self::assertEquals(1, $buchung->getStatus());
        self::assertEquals('357,00', $buchung->getSumme());
        self::assertEquals('357,00', $buchung->getSummeFw());
        self::assertEquals('000001', $buchung->getBelegNr());
        self::assertEquals('', $buchung->getReferenz());
        self::assertEquals('', $buchung->getNotizen());
        self::assertEquals(1200, $buchung->getKontoSoll());
        self::assertEquals(0, $buchung->getKontoHaben());
        self::assertEquals('EUR', $buchung->getWaehrung());
        self::assertEquals('1,00000000', $buchung->getKurs());
        self::assertEquals('<div>', $buchung->getSteuersatz());
        self::assertEquals(1, $buchung->getFestschreibStatus());
        self::assertInstanceOf(BuchungJournalItemListCollection::class , $buchung->getBuchungJournalItemList());
        self::assertIsArray($buchung->getAttachmentIdList());
        self::assertEquals([], $buchung->getAttachmentIdList());
    }

    /**
     * @test
     */
    public function buchungTemplate(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungTemplate',
            'Buchungen/buchungTemplateWithThreePositions',
        ];
        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $buchungAddItem = $this->service->buchungTemplate(1);

        self::assertEquals('', $buchungAddItem->getDatum());
        self::assertEquals('', $buchungAddItem->getText());
        self::assertEquals('', $buchungAddItem->getBelegNr());
        self::assertEquals('', $buchungAddItem->getReferenz());
        self::assertEquals('', $buchungAddItem->getNotizen());
        self::assertEquals('EUR', $buchungAddItem->getWaehrung());
        self::assertEquals('', $buchungAddItem->getKurs());
        self::assertCount(1, $buchungAddItem->getBuchungPositionItemList());

        $buchungAddItem = $this->service->buchungTemplate(3);
        self::assertCount(3, $buchungAddItem->getBuchungPositionItemList());
    }

    /**
     * @test
     */
    public function buchungAdd(): void
    {
        $this->mockResponseBodies = [
            'Buchungen/buchungTemplate',
            'Buchungen/BuchungAddResponses/buchungAddResponse',
        ];
        $this->createMockClient();
        $this->service = new BuchungenService($this->client);

        $buchungAddItem = $this->service->buchungTemplate(1);

        $buchungAddItem->setDatum('2023-04-06');
        $buchungAddItem->setText('Testbuchung');
        $buchungAddItem->setWaehrung('EUR');
        $buchungAddItem->setKurs('EUR');
        $buchungAddItem->getBuchungPositionItemList()[0]->setBetrag('42,00');
        $buchungAddItem->getBuchungPositionItemList()[0]->setKontoSoll(10000);
        $buchungAddItem->getBuchungPositionItemList()[0]->setKontoHaben(8400);
        $buchungAddItem->getBuchungPositionItemList()[0]->setText('Position 1');
        $buchungAddItem->getBuchungPositionItemList()[0]->getOssDaten()->setTyp(1);

        $response = $this->service->buchungAdd($buchungAddItem);
        self::assertTrue($response->isOk());
    }
}
