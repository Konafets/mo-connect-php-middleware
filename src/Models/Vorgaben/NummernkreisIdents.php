<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben;

use ArrobaIt\MoConnectApi\Models\ResponseTrait;
use stdClass;

/**
 * Class NummernkreisIdents
 *
 * @package ArrobaIt\MoConnectApi\Models\Vorgaben
 * @author Stefano Kowalke <info@arroba-it.de>
 * @todo Add methods which returns the string representation of the idents
 */
class NummernkreisIdents
{
    use ResponseTrait;

    protected array $idents = [
        1 => 'Verkauf Angebot',
        2 => 'Verkauf Auftragsbestätigung',
        3 => 'Verkauf Lieferschein',
        4 => 'Verkauf Rechnung',
        5 => 'Verkauf Korrekturrechnung',
        6 => 'Stammdaten Artikel',
        7 => 'Stammdaten Leistung',
        8 => 'Stammdaten Adresse',
        9 => 'Verkauf Abschlagsrechnung',
        10 => 'Einkauf Bestellanfrage',
        11 => 'Einkauf Bestellung',
        12 => 'Einkauf Wareneingang',
        13 => 'Einkauf Eingangsrechnung',
        14 => 'Einkauf Lieferantengutschrift',
        15 => 'Einkauf Rücksendung',
        16 => 'Einkauf Storno',
        17 => 'Verkauf Proformarechnung',
        19 => 'Buchhaltung Buchung',
        20 => '',
        21 => '',
    ];

    protected int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromResponse(stdClass $response): self
    {
        self::$content = $response;

        return new self();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
