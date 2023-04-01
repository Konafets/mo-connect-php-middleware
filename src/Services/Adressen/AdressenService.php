<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Adressen;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseAddItem;
use ArrobaIt\MoConnectApi\Models\Adressen\AdresseFilter;
use ArrobaIt\MoConnectApi\Models\Adressen\AdresseItem;
use ArrobaIt\MoConnectApi\Models\Adressen\AnsprechpartnerAddItem;
use ArrobaIt\MoConnectApi\Models\Adressen\AnsprechpartnerItem;
use ArrobaIt\MoConnectApi\Models\Adressen\Collections\AdresseKategorieItems;
use ArrobaIt\MoConnectApi\Models\Adressen\Collections\AdresseListItemCollection;
use ArrobaIt\MoConnectApi\Models\Adressen\Collections\AnsprechpartnerListItems;
use ArrobaIt\MoConnectApi\Models\Adressen\Collections\SepaMandatListItems;
use ArrobaIt\MoConnectApi\Models\Adressen\SepaMandatAddItem;
use ArrobaIt\MoConnectApi\Models\Adressen\SepaMandatItem;
use ArrobaIt\MoConnectApi\Models\Adressen\SepaMandatPrintItem;
use ArrobaIt\MoConnectApi\Models\Http\ReturnStatus;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class AdressenService extends BaseService
{
    /**
     * Vorlage für Adressen-Filter
     */
    public function adresseFilterTemplate(): AdresseFilter
    {
        $request = [
            'adresseFilterTemplate' => '',
        ];

        try {
            $response = $this->client->send($request);
            return AdresseFilter::fromResponse(
                $response->adresseFilterTemplateResponse->ReturnData->AdresseFilter
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert alle Adressen als Liste
     */
    public function adresseList(AdresseFilter $filter = null): AdresseListItemCollection
    {
        $request = [
            'adresseList' => [
                'AdresseFilter' => '',
            ],
        ];

        if ($filter instanceof AdresseFilter) {
            $request['adresseList']['AdresseFilter'] = $filter->__toArray();
        }

        try {
            $response = $this->client->send($request);
            return AdresseListItemCollection::fromResponse(
                $response->adresseListResponse->ReturnData->AdresseListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert Details einer Adresse
     */
    public function adresseGet(string $id): AdresseItem
    {
        $request = [
            'adresseGet' => [
                'Adresse_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return AdresseItem::fromResponse(
                $response->adresseGetResponse->ReturnData->AdresseItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Fügt eine Adresse hinzu
     */
    public function adresseAdd(AdresseAddItem $adresseAddItem): ReturnStatus
    {
        $request = [
            'adresseAdd' => [
                'AdresseAddItem' => $adresseAddItem->__toArray(),
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseAddResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Modifiziert vorhandene Adresse
     *
     * Ablauf:
     *    1. Struktur AdresseItem über adresseGet abrufen.Es wird ein gültiger VersionKey geliefert.
     *    2. Daten von AdresseItem bei Bedarf anpassen.
     *    3. Funktion adresseModify ausführen.
     *    Es wird ein Status über Erfolg/Fehler der Operation zurückgeliefert.
     *    Hinweis: Es sind nicht alle Daten von AdresseItem modifizierbar.
     *    Es sollten nur die Parameter übergeben werden, welche auch geändert werden sollen. Alle anderen sollten aus AdresseItem entfernt werden.
     *
     *    Beispielaufruf Änderung Vorname (Adresse_ID,VersionKey beispielhaft)
     *    {
     *      "adresseModify":{
     *        "AdresseItem":{
     *          "Adresse_ID":"481A62479DF4207DB23598B6461308",
     *          "VersionKey":"99276D86013D6FE47EFB22572D96B63624",
     *           "RA_Vorname":"Paul"
     *        }
     *      }
     *    }
     */
    public function adresseModify(AdresseItem $adresseItem): ReturnStatus
    {
        $request = [
            'adresseModify' => [
                'AdresseItem' => $adresseItem->__toArray(),
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseModifyResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Löscht vorhandene Adresse
     */
    public function adresseDelete(string $addresseId): ReturnStatus
    {
        $request = [
            'adresseDelete' => [
                'Adresse_ID' => $addresseId
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseDeleteResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert AdresseAddItem als Vorlage
     */
    public function adresseTemplate(): AdresseAddItem
    {
        $request = [
            'adresseTemplate' => '',
        ];

        try {
            $response = $this->client->send($request);
            return AdresseAddItem::fromResponse(
                $response->adresseTemplateResponse->ReturnData->AdresseAddItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Ermittelt alle Adress-Kategorien
     */
    public function adresseKategorieList(): AdresseKategorieItems
    {
        $request = [
            'adresseKategorieList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return AdresseKategorieItems::fromResponse(
                $response->adresseKategorielistResponse->ReturnData->AdresseKategorieItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Fügt ein Attachment einer Adresse hinzu
     */
    public function adresseAddAttachment(string $addresseId, AttachmentAddItem $attachmentAddItem): ?ReturnStatus
    {
        $request = [
            'adresseAddAttachment' => [
                'Adresse_ID' => $addresseId,
                'AttachmentAddItem' => $attachmentAddItem
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseAddAttachmentResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert AnsprechpartnerAddItem als Vorlage
     */
    public function adresseAnsprechpartnerTemplate(string $adresseId = null): AnsprechpartnerAddItem
    {
        $request = [
            'adresseAnsprechpartnerTemplate' => [
                'Adresse_ID' => $adresseId
            ],
        ];

        try {
            $response = $this->client->send($request);
            return AnsprechpartnerAddItem::fromResponse(
                $response->adresseAnsprechpartnerTemplateResponse->ReturnData->AnsprechpartnerAddItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert alle Ansprechpartner einer Adresse
     */
    public function adresseAnsprechpartnerList(string $adresseId): AnsprechpartnerListItems
    {
        $request = [
            'adresseAnsprechpartnerList' => [
                'Adresse_ID' => $adresseId
            ],
        ];

        try {
            $response = $this->client->send($request);
            return AnsprechpartnerListItems::fromResponse(
                $response->adresseAnsprechpartnerListResponse->ReturnData->AnsprechpartnerListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Fügt Ansprechpartner zu Adresse hinzu
     */
    public function adresseAnsprechpartnerAdd(AnsprechpartnerAddItem $ansprechpartnerAddItem): ?ReturnStatus
    {
        $request = [
            'adresseAnsprechpartnerAdd' => [
                'AnsprechpartnerAddItem' => $ansprechpartnerAddItem
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseAnsprechpartnerAddResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert Details eines einzelnen Ansprechpartner
     */
    public function adresseAnsprechpartnerGet(string $id)
    {
        $request = [
            'adresseAnsprechpartnerGet' => [
                'Ansprechpartner_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return AnsprechpartnerItem::fromResponse(
                $response->adresseAnsprechpartnerGetResponse->ReturnData->AnsprechpartnerItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Modifiziert vorhandenen Ansprechpartner
     *
     * Ablauf:
     *    1. Struktur AnsprechpartnerItem über adresseAnsprechpartnerGet abrufen. Es wird ein gültiger VersionKey geliefert.
     *    2. Daten von AnsprechpartnerItem bei Bedarf anpassen.
     *    3. Funktion adresseAnsprechpartnerModify ausführen.
     *    Es wird ein Status über Erfolg/Fehler der Operation zurückgeliefert.
     *    Hinweis: Es sind nicht alle Daten von AnsprechpartnerItem modifizierbar.
     *    Es sollten nur die Parameter übergeben werden, welche auch geändert werden sollen. Alle anderen sollten aus AnsprechpartnerItem entfernt werden.
     *    Beispielaufruf Änderung Nachname (Adresse_ID,Ansprechpartner_ID,VersionKey beispielhaft)
     *
     *    {
     *     "adresseAnsprechpartnerModify":{
     *        "AnsprechpartnerItem":{
     *         "Adresse_ID":"480C644B85E2297DB23598B04C18",
     *         "Ansprechpartner_ID":"4806655E84F42F4A8B10D0F3184C4BC98F057A8BEFAE",
     *         "VersionKey":"067EF8D83D7912D08D53C8CDD06A7E0D73",
     *         "Nachname":"Mustermann"
     *       }
     *      }
     *    }
     *
     */
    public function adresseAnsprechpartnerModify(AnsprechpartnerItem $ansprechpartnerItem): ?ReturnStatus
    {
        $request = [
            'adresseAnsprechpartnerModify' => [
                'AnsprechpartnerItem' => $ansprechpartnerItem
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseAnsprechpartnerModifyResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Löscht eine Ansprechpartner
     */
    public function adresseAnsprechpartnerDelete(string $id): ?ReturnStatus
    {
        $request = [
            'adresseAnsprechpartnerDelete' => [
                'Ansprechpartner_ID' => $id,
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseAnsprechpartnerDeleteResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Auflistung angelegter SEPA-Mandate für Adresse
     */
    public function adresseSepaMandatList(string $id): SepaMandatListItems
    {
        $request = [
            'adresseSepaMandatList' => [
                'Adresse_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            // Array vom Typ SepaMandatListItem
            return SepaMandatListItems::fromResponse(
                $response->adresseSepaMandatListResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Vorlage für neues SEPA-Mandat
     */
    public function adresseSepaMandatTemplate(string $id): ?SepaMandatAddItem
    {
        $request = [
            'adresseSepaMandatTemplate' => [
                'Adresse_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return SepaMandatAddItem::fromResponse(
                $response->adresseSepaMandatTemplateResponse->ReturnData->SepaMandatAddItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Anlegen eines SEPA-Mandat für Adresse
     */
    public function adresseSepaMandatAdd(SepaMandatAddItem $sepaMandatAddItem): ?ReturnStatus
    {
        $request = [
            'adresseSepaMandatAdd' => [
                'SepaMandatAddItem' => $sepaMandatAddItem
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseSepaMandatAddResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert Details eines vorhandenen SEPA-Mandat
     */
    public function adresseSepaMandatGet(string $id): ?SepaMandatItem
    {
        $request = [
            'adresseSepaMandatGet' => [
                'SepaMandat_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return SepaMandatItem::fromResponse(
                $response->adresseSepaMandatGetResponse->ReturnData->SepaMandatItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Modifiziert vorhandenes SEPA-Mandat
     */
    public function adresseSepaMandatModify(SepaMandatItem $sepaMandatItem): ReturnStatus
    {
        $request = [
            'adresseSepaMandatModify' => [
                'SepaMandatItem' => $sepaMandatItem
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseSepaMandatModifyResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Löscht vorhandenes SEPA-Mandat
     */
    public function adresseSepaMandatDelete(string $id): ReturnStatus
    {
        $request = [
            'adresseSepaMandatDelete' => [
                'SepaMandat_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->adresseSepaMandatDeleteResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Gibt SEPA-Mandat als PDF aus
     */
    public function adresseSepaMandatPrintPDF(string $id, string $name): SepaMandatPrintItem
    {
        $request = [
            'adresseSepaMandatPrintPDF' => [
                'SepaMandat_ID' => $id,
                'DruckformularName' => $name,
            ],
        ];

        try {
            $response = $this->client->send($request);
            return SepaMandatPrintItem::fromResponse(
                $response->adresseSepaMandatPrintPDFResponse->ReturnData->SepaMandatPrintItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
