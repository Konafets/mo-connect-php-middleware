<?php declare(strict_types=1);

namespace ArrobaIt\Tests\ApiInformation;

use ArrobaIt\MoConnectApi\Services\SessionInfoService;
use ArrobaIt\Tests\BaseTest;

final class SessionInfoTest extends BaseTest
{
    protected SessionInfoService $service;

    protected string $nameOfBodyMockFile = 'apisessioninfoGetResponse';

    protected $result;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new SessionInfoService($this->client);
        $this->result = $this->service->apiSessioninfoGet();
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsAppDatenBank(): void
    {
        self::assertSame('cubeSQL@localhost:4430:admin:Business.sdb', $this->result->getAppDatenBank());
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsAppDbSchemaVersion(): void
    {
        self::assertSame(91, $this->result->getAppDbSchemaVersion());
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsFirmaId(): void
    {
        self::assertSame('4F01644397CE0566C14498B2', $this->result->getFirmaId());
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsBenutzerId(): void
    {
        self::assertSame('4B0D785B82EB2950A438E6BD44130C', $this->result->getBenutzerId());
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsUserName(): void
    {
        self::assertSame('jane.doe', $this->result->getUserName());
    }

    /**
     * @test
     */
    public function apiSessionInfoContainsUserAccessItemList(): void
    {
        self::assertCount(14, $this->result->getUserAccessItemList());
    }

    /**
     * @test
     */
    public function apiSessionInfoHasUserAccessItem(): void
    {
        $userAccessItemList = $this->result->getUserAccessItemList();

        self::assertSame('firmen', $userAccessItemList[0]->getModuleId());
        self::assertSame('Firmen', $userAccessItemList[0]->getModuleName());
        self::assertTrue($userAccessItemList[0]->isZugriff());
        self::assertFalse($userAccessItemList[0]->isAnlegen());
        self::assertFalse($userAccessItemList[0]->isAendern());
        self::assertFalse($userAccessItemList[0]->isLoeschen());

        self::assertSame('vorgaben', $userAccessItemList[1]->getModuleId());
        self::assertSame('Vorgaben', $userAccessItemList[1]->getModuleName());
        self::assertTrue($userAccessItemList[1]->isZugriff());
        self::assertFalse($userAccessItemList[1]->isAnlegen());
        self::assertFalse($userAccessItemList[1]->isAendern());
        self::assertFalse($userAccessItemList[1]->isLoeschen());

        self::assertSame('adressen', $userAccessItemList[2]->getModuleId());
        self::assertSame('Adressen', $userAccessItemList[2]->getModuleName());
        self::assertTrue($userAccessItemList[2]->isZugriff());
        self::assertTrue($userAccessItemList[2]->isAnlegen());
        self::assertTrue($userAccessItemList[2]->isAendern());
        self::assertTrue($userAccessItemList[2]->isLoeschen());

        self::assertSame('artikel', $userAccessItemList[3]->getModuleId());
        self::assertSame('Artikel und Leistungen', $userAccessItemList[3]->getModuleName());
        self::assertTrue($userAccessItemList[3]->isZugriff());
        self::assertTrue($userAccessItemList[3]->isAnlegen());
        self::assertTrue($userAccessItemList[3]->isAendern());
        self::assertTrue($userAccessItemList[3]->isLoeschen());

        self::assertSame('lager', $userAccessItemList[4]->getModuleId());
        self::assertSame('Lager', $userAccessItemList[4]->getModuleName());
        self::assertTrue($userAccessItemList[4]->isZugriff());
        self::assertFalse($userAccessItemList[4]->isAnlegen());
        self::assertFalse($userAccessItemList[4]->isAendern());
        self::assertFalse($userAccessItemList[4]->isLoeschen());

        self::assertSame('verkauf', $userAccessItemList[5]->getModuleId());
        self::assertSame('Verkaufsbelege', $userAccessItemList[5]->getModuleName());
        self::assertTrue($userAccessItemList[5]->isZugriff());
        self::assertTrue($userAccessItemList[5]->isAnlegen());
        self::assertFalse($userAccessItemList[5]->isAendern());
        self::assertTrue($userAccessItemList[5]->isLoeschen());

        self::assertSame('einkauf', $userAccessItemList[6]->getModuleId());
        self::assertSame('Einkaufsbelege', $userAccessItemList[6]->getModuleName());
        self::assertTrue($userAccessItemList[6]->isZugriff());
        self::assertTrue($userAccessItemList[6]->isAnlegen());
        self::assertFalse($userAccessItemList[6]->isAendern());
        self::assertTrue($userAccessItemList[6]->isLoeschen());

        self::assertSame('buchungen', $userAccessItemList[7]->getModuleId());
        self::assertSame('Buchungen', $userAccessItemList[7]->getModuleName());
        self::assertTrue($userAccessItemList[7]->isZugriff());
        self::assertTrue($userAccessItemList[7]->isAnlegen());
        self::assertFalse($userAccessItemList[7]->isAendern());
        self::assertFalse($userAccessItemList[7]->isLoeschen());

        self::assertSame('debitoren', $userAccessItemList[8]->getModuleId());
        self::assertSame('Debitoren', $userAccessItemList[8]->getModuleName());
        self::assertTrue($userAccessItemList[8]->isZugriff());
        self::assertTrue($userAccessItemList[8]->isAnlegen());
        self::assertFalse($userAccessItemList[8]->isAendern());
        self::assertTrue($userAccessItemList[8]->isLoeschen());

        self::assertSame('kreditoren', $userAccessItemList[9]->getModuleId());
        self::assertSame('Kreditoren', $userAccessItemList[9]->getModuleName());
        self::assertTrue($userAccessItemList[9]->isZugriff());
        self::assertTrue($userAccessItemList[9]->isAnlegen());
        self::assertFalse($userAccessItemList[9]->isAendern());
        self::assertTrue($userAccessItemList[9]->isLoeschen());

        self::assertSame('offenePosten', $userAccessItemList[10]->getModuleId());
        self::assertSame('Offene Posten', $userAccessItemList[10]->getModuleName());
        self::assertTrue($userAccessItemList[10]->isZugriff());
        self::assertFalse($userAccessItemList[10]->isAnlegen());
        self::assertFalse($userAccessItemList[10]->isAendern());
        self::assertFalse($userAccessItemList[10]->isLoeschen());

        self::assertSame('projekte', $userAccessItemList[11]->getModuleId());
        self::assertSame('Projekte', $userAccessItemList[11]->getModuleName());
        self::assertTrue($userAccessItemList[11]->isZugriff());
        self::assertFalse($userAccessItemList[11]->isAnlegen());
        self::assertFalse($userAccessItemList[11]->isAendern());
        self::assertFalse($userAccessItemList[11]->isLoeschen());

        self::assertSame('attachment', $userAccessItemList[12]->getModuleId());
        self::assertSame('Attachment-Verwaltung', $userAccessItemList[12]->getModuleName());
        self::assertTrue($userAccessItemList[12]->isZugriff());
        self::assertTrue($userAccessItemList[12]->isAnlegen());
        self::assertFalse($userAccessItemList[12]->isAendern());
        self::assertTrue($userAccessItemList[12]->isLoeschen());

        self::assertSame('apiinfo', $userAccessItemList[13]->getModuleId());
        self::assertSame('API Information', $userAccessItemList[13]->getModuleName());
        self::assertTrue($userAccessItemList[13]->isZugriff());
        self::assertFalse($userAccessItemList[13]->isAnlegen());
        self::assertFalse($userAccessItemList[13]->isAendern());
        self::assertFalse($userAccessItemList[13]->isLoeschen());
    }
}
