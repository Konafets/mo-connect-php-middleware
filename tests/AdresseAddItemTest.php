<?php declare(strict_types=1);

namespace ArrobaIt\Tests;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseAddItem;
use PHPUnit\Framework\TestCase;

final class AdresseAddItemTest extends TestCase
{
    protected AdresseAddItem $subject;

    /**
     * @test
     */
    public function adresseItemAddExpectesMatchCode(): void
    {
        $this->subject = new AdresseAddItem('FOO');
        self::assertEquals('FOO', $this->subject->getMatchCode());
    }

    /**
     * @test
     */
    public function adresseItemAddToArray(): void
    {
        $this->subject = new AdresseAddItem('FOO');
        self::assertArrayHasKey('Matchcode', $this->subject->__toArray());
    }

    /**
     * @test
     */
    public function adresseItemAddToArrayContainsCorrectAmountOfItems(): void
    {
        $this->subject = new AdresseAddItem('FOO');
        self::assertCount(80, $this->subject->__toArray());
    }
}

