<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Firma;

use ArrobaIt\MoConnectApi\Models\Firmen\FirmaItem;
use ArrobaIt\MoConnectApi\Services\FirmaItemService;
use ArrobaIt\Tests\BaseTest;

final class FirmaItemTest extends BaseTest
{
    protected FirmaItemService $service;

    protected array $mockReponseBodies = [
        'Firma/firmaGetResponse'
    ];

    protected FirmaItem $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new FirmaItemService($this->client);
        $this->result = $this->service->firmaGet();
    }

    /**
     * @test
     */
    public function firmaGetReturnsName(): void
    {
        self::assertEquals('Acme', $this->result->getName());
        self::assertEquals('Inc.', $this->result->getZusatz());
        self::assertEquals('Jane Doe', $this->result->getGeschaeftsfuehrer());
        self::assertEquals('Infinite Loop 1', $this->result->getStrasse());
        self::assertEquals('12345', $this->result->getPlz());
        self::assertEquals('Flensburg', $this->result->getOrt());
        self::assertEquals('1111-11111', $this->result->getTelefon());
        self::assertEquals('1111-11111-11', $this->result->getTelefax());
        self::assertEquals('info@acme.de', $this->result->getEmail());
        self::assertEquals('acme.de', $this->result->getInternet());
        self::assertEquals('Flensburg', $this->result->getRegisterGericht());
        self::assertEquals('123456', $this->result->getRegisterNummer());
        self::assertEquals('DE87500105179335922224', $this->result->getIban());
        self::assertEquals('BYLADEM1001', $this->result->getBic());
        self::assertEquals('Geschäftskonto', $this->result->getBankName());
        self::assertTrue($this->result->getUstPflicht());
        self::assertEquals('DE123456789', $this->result->getUstIdNummer());
        self::assertEquals('DATEV SKR 04 (EÜ)', $this->result->getKontenplan());
        self::assertEquals(2, $this->result->getGeArt());
        self::assertEquals('Deutschland', $this->result->getFaLand());
        self::assertEquals('1234', $this->result->getFaNummber());
        self::assertEquals('Flensburg', $this->result->getFaName());
        self::assertEquals('', $this->result->getFaZusatz());
        self::assertEquals('Duburger Str. 58-64', $this->result->getFaStrasse());
        self::assertEquals('24939', $this->result->getFaPlz());
        self::assertEquals('Flensburg', $this->result->getFaOrt());
        self::assertEquals('Schleswig-Holstein', $this->result->getFaBundesland());
        self::assertEquals('11', $this->result->getFaStNrPrefix());
        self::assertEquals('11 111 11111', $this->result->getFaSteuernummer());
        self::assertEquals('11', $this->result->getFaStNrPostfix());
        self::assertEquals('1111 111-0', $this->result->getFaTelefon());
        self::assertEquals('1111 111-111', $this->result->getFaTelefax());
        self::assertEquals('Bundesbank', $this->result->getFaBankName());
        self::assertEquals('DE27200000000020201500', $this->result->getFaBankIban());
        self::assertEquals('MARKDEF1200', $this->result->getFaBankBic());
        self::assertEquals('', $this->result->getFaMemo());
        self::assertEquals('', $this->result->getSbName());
        self::assertEquals('', $this->result->getSbZusatz());
        self::assertEquals('', $this->result->getSbStrasse());
        self::assertEquals('', $this->result->getSbPlz());
        self::assertEquals('', $this->result->getSbOrt());
        self::assertEquals('', $this->result->getSbTelefon());
        self::assertEquals('', $this->result->getSbTelefax());
        self::assertEquals('', $this->result->getSbEmail());
        self::assertEquals('', $this->result->getSbBankName());
        self::assertEquals('', $this->result->getSbBankIban());
        self::assertEquals('', $this->result->getSbBankBic());
        self::assertEquals('', $this->result->getSbMemo());
        self::assertEquals('Deutschland', $this->result->getFaLandLSt());
        self::assertEquals('2115', $this->result->getFaNummerLSt());
        self::assertEquals('Flensburg', $this->result->getFaNameLSt());
        self::assertEquals('', $this->result->getFaZusatzLSt());
        self::assertEquals('Duburger Str. 58-64', $this->result->getFaStrasseLSt());
        self::assertEquals('24939', $this->result->getFaPlzLSt());
        self::assertEquals('Flensburg', $this->result->getFaOrtLSt());
        self::assertEquals('Schleswig-Holstein', $this->result->getFaBundeslandLSt());
        self::assertEquals('11', $this->result->getFaStNrPrefixLSt());
        self::assertEquals('11 111 11111', $this->result->getFaSteuernummerLSt());
        self::assertEquals('11', $this->result->getFaStNrPostfixLSt());
        self::assertEquals('Bundesbank', $this->result->getFaBankNameLSt());
        self::assertEquals('DE27200000000020201500', $this->result->getFaBankIbanLSt());
        self::assertEquals('MARKDEF1200', $this->result->getFaBankBicLSt());
        self::assertEquals('', $this->result->getFaMemoLSt());
        self::assertEquals('', $this->result->getLgName());
        self::assertEquals('', $this->result->getLgZusatz());
        self::assertEquals('', $this->result->getLgVerwalter());
        self::assertEquals('', $this->result->getLgStrasse());
        self::assertEquals('', $this->result->getLgPlz());
        self::assertEquals('', $this->result->getLgOrt());
        self::assertEquals('', $this->result->getLgTelefon());
        self::assertEquals('', $this->result->getLgTelefax());
        self::assertEquals('', $this->result->getLgEmail());
        self::assertEquals('2008-01-01', $this->result->getDatumVon()->toDateString());
        self::assertEquals('2021-12-31', $this->result->getDatumBis()->toDateString());
    }
}

