<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Firma;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseAddItem;
use ArrobaIt\MoConnectApi\Models\Adressen\AdresseFilter;
use ArrobaIt\MoConnectApi\Services\Adressen\AdressenService;
use ArrobaIt\Tests\BaseTest;

final class AdressenServiceTest extends BaseTest
{
    protected AdressenService $service;

    public function setup(): void
    {

    }

    /**
     * @test
     */
    public function adressFilterTemplate(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseFilterTemplateResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adresseFilterTemplate = $this->service->adresseFilterTemplate();
        self::assertEquals('Foo', $adresseFilterTemplate->getSuchtext());
        self::assertEquals('FOOBARBAZ', $adresseFilterTemplate->getMatchcode());
        self::assertEquals('1', $adresseFilterTemplate->getAdresseKategorie());
        self::assertEquals('-2', $adresseFilterTemplate->getLieferantenStatus());
        self::assertEquals('ohne Status', $adresseFilterTemplate->getLieferantenStatusBeschreibung());
        self::assertEquals('1', $adresseFilterTemplate->getKundenStatus());
        self::assertEquals('Ist aktiver Kunde bzw. Lieferant', $adresseFilterTemplate->getKundenStatusBeschreibung());
    }

    /**
     * @test
     */
    public function getAdressenListWithoutFilter(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseListResponseWithoutFilter',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();

        self::assertCount(2, $adressen);

        self::assertEquals('480C644B85E2297DB23598BF44130C', $adressen[0]->getAdresseID());
        self::assertEquals('ACME', $adressen[0]->getMatchcode());
        self::assertEquals('ADR-00001', $adressen[0]->getAdressNr());
        self::assertEquals('', $adressen[0]->getKategorie());
        self::assertEquals(1, $adressen[0]->getKundenStatus());
        self::assertEquals('Ist aktiver Kunde bzw. Lieferant', $adressen[0]->getKundenStatusBeschreibung());
        self::assertEquals(0, $adressen[0]->getLieferantenStatus());
        self::assertEquals('Ist kein Kunde bzw. Lieferant', $adressen[0]->getLieferantenStatusBeschreibung());
        self::assertEquals('Acme', $adressen[0]->getRaFirma1());
        self::assertEquals('Road', $adressen[0]->getRaVorname());
        self::assertEquals('Runner', $adressen[0]->getRaNachname());
        self::assertEquals('12345', $adressen[0]->getRaPlz());
        self::assertEquals('Buxthude', $adressen[0]->getRaOrt());
        self::assertEquals('Straße', $adressen[0]->getRaStrasse());
        self::assertEquals('10', $adressen[0]->getRaStrasseNr());
    }

    /**
     * @test
     */
    public function getAdressenListWithFilter(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseListResponseWithFilter',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $filter = new AdresseFilter();
        $filter->setMatchcode('FOO');

        $adressen = $this->service->adresseList($filter);

        self::assertCount(1, $adressen);

        self::assertEquals('480C644B85E2297DB23598B347130C', $adressen[0]->getAdresseID());
        self::assertEquals('FOO', $adressen[0]->getMatchcode());
        self::assertEquals('ADR-00002', $adressen[0]->getAdressNr());
        self::assertEquals('EDV-Leistungen für Geld', $adressen[0]->getKategorie());
        self::assertEquals(1, $adressen[0]->getKundenStatus());
        self::assertEquals('Ist aktiver Kunde bzw. Lieferant', $adressen[0]->getKundenStatusBeschreibung());
        self::assertEquals(0, $adressen[0]->getLieferantenStatus());
        self::assertEquals('Ist kein Kunde bzw. Lieferant', $adressen[0]->getLieferantenStatusBeschreibung());
        self::assertEquals('Foo Bar', $adressen[0]->getRaFirma1());
        self::assertEquals('Foo', $adressen[0]->getRaVorname());
        self::assertEquals('Bar', $adressen[0]->getRaNachname());
        self::assertEquals('12345', $adressen[0]->getRaPlz());
        self::assertEquals('Welt', $adressen[0]->getRaOrt());
        self::assertEquals('Norden', $adressen[0]->getRaStrasse());
        self::assertEquals('42', $adressen[0]->getRaStrasseNr());
    }

    /**
     * @test
     */
    public function adresseGet(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseGetResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $id = '480C644B85E2297DB23598BF44130C';
        $adresse = $this->service->adresseGet($id);

        self::assertEquals('480C644B85E2297DB23598BF44130C', $adresse->getAdresseId());
        self::assertEquals('8DB52B927609BBAB2CC66E9CBA546D31D3', $adresse->getVersionKey());
        self::assertEquals('ACME', $adresse->getMatchCode());
        self::assertEquals('ADR-00001', $adresse->getAdressNummer());
        self::assertEquals('', $adresse->getKategorie());
        self::assertEquals(1, $adresse->getKundenStatus());
        self::assertEquals('Ist aktiver Kunde bzw. Lieferant', $adresse->getKundenStatusBeschreibung());
        self::assertEquals(0, $adresse->getLieferantenStatus());
        self::assertEquals('Ist kein Kunde bzw. Lieferant', $adresse->getLieferantenStatusBeschreibung());
        self::assertEquals('Acme Inc.', $adresse->getRaFirma1());
        self::assertEquals('', $adresse->getRaFirma2());
        self::assertEquals('', $adresse->getRaZusatz());
        self::assertEquals('Road', $adresse->getRaVorname());
        self::assertEquals('Runner', $adresse->getRaNachname());
        self::assertEquals('12345', $adresse->getRaPlz());
        self::assertEquals('Welt', $adresse->getRaOrt());
        self::assertEquals('w', $adresse->getRaGeschlecht());
        self::assertEquals('Street', $adresse->getRaStrasse());
        self::assertEquals('10', $adresse->getRaStrasseNr());
        self::assertEquals('USA', $adresse->getRaLand());
        self::assertEquals('', $adresse->getRaLandISO());
        self::assertEquals('', $adresse->getRaPostfachPlz());
        self::assertEquals('', $adresse->getRaPostfachNr());
        self::assertFalse($adresse->isRaPfVerwenden());
        self::assertEquals('', $adresse->getRaTelefon1());
        self::assertEquals('', $adresse->getRaTelefon2());
        self::assertEquals('', $adresse->getRaTelefon3());
        self::assertEquals('', $adresse->getRaTelefax());
        self::assertEquals('', $adresse->getRaEmail());
        self::assertEquals('', $adresse->getRaInternet());

        self::assertEquals('', $adresse->getLaFirma1());
        self::assertEquals('', $adresse->getLaFirma2());
        self::assertEquals('', $adresse->getLaZusatz());
        self::assertEquals('', $adresse->getLaVorname());
        self::assertEquals('', $adresse->getLaNachname());
        self::assertEquals('', $adresse->getLaPlz());
        self::assertEquals('', $adresse->getLaOrt());
        self::assertEquals('', $adresse->getLaStrasse());
        self::assertEquals('', $adresse->getLaStrasseNr());
        self::assertEquals('', $adresse->getLaLand());
        self::assertEquals('', $adresse->getLaPostfachPlz());
        self::assertEquals('', $adresse->getLaPostfachNr());
        self::assertFalse($adresse->isLaPfVerwenden());
        self::assertEquals('', $adresse->getLaTelefax());
        self::assertEquals('', $adresse->getLaEmail());
        self::assertEquals('', $adresse->getLaLieferart());

        self::assertEquals(10026, $adresse->getKfKonto());
        self::assertFalse($adresse->isKfSammelkonto());
        self::assertEquals('Überweisung bis zum (14 Tage)', $adresse->getKfZahlungsbedingungen());
        self::assertEquals(4400, $adresse->getKfErtragkonto());
        self::assertEquals('EUR', $adresse->getKfWaehrung());
        self::assertEquals(1810, $adresse->getKfFinanzKonto());
        self::assertEquals(0, $adresse->getKfPreisangabe());
        self::assertEquals('Standard', $adresse->getKfPreisangabeBeschreibung());
        self::assertEquals('', $adresse->getKfKoSt1());
        self::assertEquals('', $adresse->getKfKoSt2());
        self::assertEquals('', $adresse->getKfExterneNr());
        self::assertFalse($adresse->isKfLieferstopp());
        self::assertEquals('0,00', $adresse->getKfRabatt());
        self::assertEquals('', $adresse->getKfPreislisteID());
        self::assertEquals('', $adresse->getKfBankdaten()->getIban());
        self::assertEquals('', $adresse->getKfBankdaten()->getBic());
        self::assertEquals('', $adresse->getKfBankdaten()->getBank());
        self::assertEquals('', $adresse->getKfBankdaten()->getInhaber());

        self::assertEquals(0, $adresse->getLfKonto());
        self::assertFalse($adresse->isLfSammelkonto());
        self::assertEquals('', $adresse->getLfZahlungsbedingungen());
        self::assertEquals(0, $adresse->getLfAufwandkonto());
        self::assertEquals('EUR', $adresse->getLfWaehrung());
        self::assertEquals(0, $adresse->getLfFinanzKonto());
        self::assertEquals(0, $adresse->getLfPreisangabe());
        self::assertEquals('', $adresse->getLfKoSt1());
        self::assertEquals('', $adresse->getLfKoSt2());
        self::assertEquals('', $adresse->getLfExterneNr());
        self::assertFalse($adresse->isLfBestellstopp());
        self::assertEquals('0,00', $adresse->getLfRabatt());
        self::assertEquals('', $adresse->getLfBankdaten()->getIban());
        self::assertEquals('', $adresse->getLfBankdaten()->getBic());
        self::assertEquals('', $adresse->getLfBankdaten()->getBank());
        self::assertEquals('', $adresse->getLfBankdaten()->getInhaber());
        self::assertEquals(1, $adresse->getSteuergebiet());
        self::assertEquals('Inland', $adresse->getSteuergebietBeschreibung());
        self::assertEquals('DE000000000', $adresse->getUStId());
        self::assertEquals('', $adresse->getBelegsprache());
        self::assertEquals('', $adresse->getBriefanrede());
        self::assertEquals('', $adresse->getBriefgruss());
        self::assertEquals('', $adresse->getNotizen());
        self::assertFalse($adresse->isMailPreferred());
        self::assertIsArray($adresse->getAttachmentIdList());
    }

    /**
     * @test
     */
    public function addAdressWithOutMatchCode(): void
    {
        $this->mockResponseBodies = [
            'Adressen/AdresseAddResponses/adresseAddResponse_NoMatchCode',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $newAdress = new AdresseAddItem('');
        $response = $this->service->adresseAdd($newAdress);

        self::assertFalse($response->isOk());
        self::assertEquals(
            'Datensatzprüfung (Tabelle ADRESSE, Zeile 0): Der Matchcode ist nicht vorhanden!',
            $response->getStatustextItems()->first()->getStatusText()
        );

        self::assertEquals(
            'Datensatzprüfung (Tabelle ADRESSE, Zeile 0): Der Matchcode ist nicht vorhanden! Datenbankfehler (Tabelle ADRESSE): Datensatz konnte nicht erzeugt werden. Die Adresse konnte nicht gesichert werden!',
            $response->getStatusMessage()
        );
    }

    /**
     * @test
     */
    public function addAdressWithMatchCode(): void
    {
        $this->mockResponseBodies = [
            'Adressen/AdresseAddResponses/adresseAddResponse_WithMatchCode',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $newAdress = new AdresseAddItem('FOO');
        $response = $this->service->adresseAdd($newAdress);

        self::assertTrue($response->isOk());
        self::assertEquals(
            '',
            $response->getStatustextItems()->first()->getStatusText()
        );
        self::assertEquals(
            '',
            $response->getStatusMessage()
        );
        self::assertEquals(
            '480C644B85E2297DB23598B6461903A3',
            $response->getInsertId()
        );
    }

    /**
     * @test
     */
    public function adresseModify(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseGetResponse',
            'Adressen/adresseModifyResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        // 1. Struktur AdresseItem über adresseGet abrufen. Es wird ein gültiger VersionKey geliefert.
        $id = '480C644B85E2297DB23598BF44130C';
        $adresse = $this->service->adresseGet($id);
        self::assertEquals('ACME', $adresse->getMatchCode());
        self::assertEquals('8DB52B927609BBAB2CC66E9CBA546D31D3', $adresse->getVersionKey());

        // 2. Daten von AdresseItem bei Bedarf anpassen.
        $adresse->setKategorie('foo, bar');

        // 3. Funktion adresseModify ausführen.
        $response = $this->service->adresseModify($adresse);

        self::assertTrue($response->isOk());
    }

    /**
     * @test
     */
    public function adresseDelete(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseDeleteResponse_invalidId',
            'Adressen/adresseDeleteResponse_valid',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $id = 'Foo';
        $response = $this->service->adresseDelete($id);
        self::assertFalse($response->isOk());
        self::assertEquals('Adresse ID ungültig', $response->getStatusMessage());

        $id = '480C644B85E2297DB23598BF44130C';
        $response = $this->service->adresseDelete($id);
        self::assertTrue($response->isOk());
    }

    /**
     * @test
     */
    public function adresseTemplate(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseTemplateResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adresseTemplate = $this->service->adresseTemplate();

        self::assertEmpty($adresseTemplate->getMatchCode());
        self::assertEmpty($adresseTemplate->getAdressNummer());
        self::assertEquals('EUR', $adresseTemplate->getKfWaehrung());
    }

    /**
     * @test
     */
    public function adresseKategorieList(): void
    {
        $this->mockResponseBodies = [
            'Adressen/adresseKategorieListResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $kategorien = $this->service->adresseKategorieList();
        self::assertCount(3, $kategorien);
        self::assertEquals('Foo', $kategorien[0]->getName());
        self::assertEquals('Bar', $kategorien[1]->getName());
        self::assertEquals('Baz', $kategorien[2]->getName());
    }

    /**
     * @test
     */
    public function adresseAddAttachment(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAddAttachmentResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAddAttachment();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerTemplate(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerTemplateResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerTemplate();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerList(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerListResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerAdd(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerAddResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerAdd();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerGet(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerGetResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerGet();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerModify(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerModifyResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerModify();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerDelete(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseAnsprechpartnerDeleteResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseAnsprechpartnerDelete();
    }

    /**
     * @test
     */
    public function adresseSepaMandatList(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatListResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatTemplate(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatTemplateResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatTemplate();
    }

    /**
     * @test
     */
    public function adresseSepaMandatAdd(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatAddResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatAdd();
    }

    /**
     * @test
     */
    public function adresseSepaMandatGet(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatGetResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatGet();
    }

    /**
     * @test
     */
    public function adresseSepaMandatModify(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatModifyResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatModify();
    }

    /**
     * @test
     */
    public function adresseSepaMandatDelete(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatDeleteResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatDelete();
    }

    /**
     * @test
     */
    public function adresseSepaMandatPrintPDF(): void
    {
        self::markTestIncomplete();
        $this->mockResponseBodies = [
            'Adressen/adresseSepaMandatPrintPDFResponse',
        ];
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseSepaMandatPrintPDF();
    }
}

