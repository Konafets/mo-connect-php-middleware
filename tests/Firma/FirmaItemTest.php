<?php declare(strict_types=1);

namespace ArrobaIt\Tests\Firma;

use ArrobaIt\MoConnectApi\Models\Firmen\FirmaItem;
use ArrobaIt\MoConnectApi\Services\FirmaItemService;
use ArrobaIt\Tests\BaseTest;

final class FirmaItemTest extends BaseTest
{
    protected FirmaItemService $service;

    protected string $nameOfBodyMockFile = 'Firma/firmaGetResponse';

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
        self::assertSame('Acme', $this->result->getName());
        self::assertSame('Inc.', $this->result->getZusatz());
        self::assertSame('Jane Doe', $this->result->getGeschaeftsfuehrer());
        self::assertSame('Infinite Loop 1', $this->result->getStrasse());
        self::assertSame('12345', $this->result->getPlz());
        self::assertSame('Flensburg', $this->result->getOrt());
        self::assertSame('1111-11111', $this->result->getTelefon());
        self::assertSame('1111-11111-11', $this->result->getTelefax());
        self::assertSame('info@acme.de', $this->result->getEmail());
        self::assertSame('acme.de', $this->result->getInternet());
        self::assertSame('Flensburg', $this->result->getRegisterGericht());
        self::assertSame('123456', $this->result->getRegisterNummer());
        self::assertSame('DE87500105179335922224', $this->result->getIban());
        self::assertSame('BYLADEM1001', $this->result->getBic());
        self::assertSame('Geschäftskonto', $this->result->getBankName());
        self::assertTrue($this->result->getUstPflicht());
        self::assertSame('DE123456789', $this->result->getUstIdNummer());
        self::assertSame('DATEV SKR 04 (EÜ)', $this->result->getKontenplan());
        self::assertSame(2, $this->result->getGeArt());
        self::assertSame('Deutschland', $this->result->getFaLand());
        self::assertSame('1234', $this->result->getFaNummber());
        self::assertSame('Flensburg', $this->result->getFaName());
        self::assertSame('', $this->result->getFaZusatz());
        self::assertSame('Duburger Str. 58-64', $this->result->getFaStrasse());
        self::assertSame('24939', $this->result->getFaPlz());
        self::assertSame('Flensburg', $this->result->getFaOrt());
        self::assertSame('Schleswig-Holstein', $this->result->getFaBundesland());
        self::assertSame('11', $this->result->getFaStNrPrefix());
        self::assertSame('11 111 11111', $this->result->getFaSteuernummer());
        self::assertSame('11', $this->result->getFaStNrPostfix());
        self::assertSame('1111 111-0', $this->result->getFaTelefon());
        self::assertSame('1111 111-111', $this->result->getFaTelefax());
        self::assertSame('Bundesbank', $this->result->getFaBankName());
        self::assertSame('DE27200000000020201500', $this->result->getFaBankIban());
        self::assertSame('MARKDEF1200', $this->result->getFaBankBic());
        self::assertSame('', $this->result->getFaMemo());
        self::assertSame('', $this->result->getSbName());
        self::assertSame('', $this->result->getSbZusatz());
        self::assertSame('', $this->result->getSbStrasse());
        self::assertSame('', $this->result->getSbPlz());
        self::assertSame('', $this->result->getSbOrt());
        self::assertSame('', $this->result->getSbTelefon());
        self::assertSame('', $this->result->getSbTelefax());
        self::assertSame('', $this->result->getSbEmail());
        self::assertSame('', $this->result->getSbBankName());
        self::assertSame('', $this->result->getSbBankIban());
        self::assertSame('', $this->result->getSbBankBic());
        self::assertSame('', $this->result->getSbMemo());
        self::assertSame('Deutschland', $this->result->getFaLandLSt());
        self::assertSame('2115', $this->result->getFaNummerLSt());
        self::assertSame('Flensburg', $this->result->getFaNameLSt());
        self::assertSame('', $this->result->getFaZusatzLSt());
        self::assertSame('Duburger Str. 58-64', $this->result->getFaStrasseLSt());
        self::assertSame('24939', $this->result->getFaPlzLSt());
        self::assertSame('Flensburg', $this->result->getFaOrtLSt());
        self::assertSame('Schleswig-Holstein', $this->result->getFaBundeslandLSt());
        self::assertSame('11', $this->result->getFaStNrPrefixLSt());
        self::assertSame('11 111 11111', $this->result->getFaSteuernummerLSt());
        self::assertSame('11', $this->result->getFaStNrPostfixLSt());
        self::assertSame('Bundesbank', $this->result->getFaBankNameLSt());
        self::assertSame('DE27200000000020201500', $this->result->getFaBankIbanLSt());
        self::assertSame('MARKDEF1200', $this->result->getFaBankBicLSt());
        self::assertSame('', $this->result->getFaMemoLSt());
        self::assertSame('', $this->result->getLgName());
        self::assertSame('', $this->result->getLgZusatz());
        self::assertSame('', $this->result->getLgVerwalter());
        self::assertSame('', $this->result->getLgStrasse());
        self::assertSame('', $this->result->getLgPlz());
        self::assertSame('', $this->result->getLgOrt());
        self::assertSame('', $this->result->getLgTelefon());
        self::assertSame('', $this->result->getLgTelefax());
        self::assertSame('', $this->result->getLgEmail());
        self::assertSame('2008-01-01', $this->result->getDatumVon()->toDateString());
        self::assertSame('2021-12-31', $this->result->getDatumBis()->toDateString());
    }
}

