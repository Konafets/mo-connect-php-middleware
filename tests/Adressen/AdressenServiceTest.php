<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Firma;

use ArrobaIt\MoConnectApi\Client;
use ArrobaIt\MoConnectApi\Models\Adressen\AdresseAddItem;
use ArrobaIt\MoConnectApi\Services\Adressen\AdressenService;
use ArrobaIt\MoConnectApi\Services\BaseService;
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
        $this->nameOfBodyMockFile = 'Adressen/adresseFilterTemplateResponse';
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
    public function adresseList(): void
    {
        $this->nameOfBodyMockFile = 'Adressen/adresseListResponse';
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
    public function adresseGet(): void
    {
        $this->nameOfBodyMockFile = 'Adressen/adresseGetResponse';
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
    public function adresseAdd(): void
    {
//        $this->nameOfBodyMockFile = 'Adressen/adresseAddResponse';
//        $this->createMockClient();
        $this->client = new Client($_ENV['USERNAME'], $_ENV['PASSWORD'], $_ENV['COMPANY_ID']);
        $this->service = new AdressenService($this->client);

        $newAdress = new AdresseAddItem('Konafets');
//        $newAdress->setBelegsprache('deutsch');
        $response = $this->service->adresseAdd($newAdress);

        self::assertTrue($response->getStatuscode()->isOk());
    }

    /**
     * @test
     */
    public function adresseModify(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseModifyResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseDelete(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseDeleteResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseTemplate(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseTemplateResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseKategorieList(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseKategorieListResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAddAttachment(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAddAttachmentResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerTemplate(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerTemplateResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerList(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerListResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerAdd(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerAddResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerGet(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerGetResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerModify(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerModifyResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseAnsprechpartnerDelete(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseAnsprechpartnerDeleteResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatList(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatListResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatTemplate(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatTemplateResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatAdd(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatAddResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatGet(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatGetResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatModify(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatModifyResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatDelete(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatDeleteResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }

    /**
     * @test
     */
    public function adresseSepaMandatPrintPDF(): void
    {
        self::markTestIncomplete();
        $this->nameOfBodyMockFile = 'Adressen/adresseSepaMandatPrintPDFResponse';
        $this->createMockClient();
        $this->service = new AdressenService($this->client);

        $adressen = $this->service->adresseList();
    }
}

