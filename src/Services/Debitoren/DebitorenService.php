<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Debitoren;

use ArrobaIt\MoConnectApi\Models\Debitoren\Collections\DebitorenRechnungListItemCollection;
use ArrobaIt\MoConnectApi\Models\Debitoren\Collections\DebitorenZahlungListItemCollection;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungAddItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungFilter;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenZahlungAddItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenZahlungFilter;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenZahlungItem;
use ArrobaIt\MoConnectApi\Models\Enums\ZahlungsartEnum;
use ArrobaIt\MoConnectApi\Models\Http\ReturnStatus;
use ArrobaIt\MoConnectApi\Services\BaseService;
use ArrobaIt\MoConnectApi\Services\Buchungen\AttachmentAddItem;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class DebitorenService extends BaseService
{

    /**
     * Vorlage für Filter Debitorenrechnungen
     */
    public function debitorenRechnungFilterTemplate(): DebitorenRechnungFilter
    {
        $request = [
            'debitorenRechnungFilterTemplate' => '',
        ];

        try {
            $response = $this->client->send($request);

            return DebitorenRechnungFilter::fromResponse($response->debitorenRechnungFilterTemplateResponse->ReturnData->DebitorenRechnungFilter);
        } catch (JsonException|GuzzleException $e) {

        }
    }

    /**
     * Listet alle Debitorenrechnungen
     */
    public function debitorenRechnungList(DebitorenRechnungFilter $filter = null): DebitorenRechnungListItemCollection
    {
        $request = [
            'debitorenRechnungList' => [
                'DebitorenRechnungFilter' => '',
            ],
        ];

        if ($filter instanceof DebitorenRechnungFilter) {
            $request['debitorenRechnungList']['DebitorenRechnungFilter'] = $filter->__toArray();
        }

        try {
            $response = $this->client->send($request);
            return DebitorenRechnungListItemCollection::fromResponse($response->debitorenRechnungListResponse->ReturnData->DebitorenRechnungListItem);
        } catch (JsonException|GuzzleException $e) {

        }
    }

    /**
     * Liefert Details einer Debitorenrechnung
     */
    public function debitorenRechnungGet(string $id): DebitorenRechnungItem
    {
        $request = [
            'debitorenRechnungGet' => [
                'Posten_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return DebitorenRechnungItem::fromResponse(
                $response->debitorenRechnungGetResponse->ReturnData->DebitorenRechnungItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert DebitorenRechnungAddItem als Vorlage
     */
    public function debitorenRechnungTemplate(string $addressId = '', string $date = '', int $positionCount = 1): DebitorenRechnungAddItem
    {
        $request = [
            'debitorenRechnungTemplate' => [
                'Adresse_ID' => $addressId,
                'Datum' => $date,
                'Positionenanzahl' => $positionCount
            ],
        ];

        try {
            $response = $this->client->send($request);
            return DebitorenRechnungAddItem::fromResponse(
                $response->debitorenRechnungTemplateResponse->ReturnData->DebitorenRechnungAddItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    public function debitorenRechnungPreview(): DebitorenRechnungItem
    {
        // TODO:
    }

    /**
     * Fügt eine neue Debitorenrechnung hinzu
     */
    public function debitorenRechnungAdd(DebitorenRechnungAddItem $debitorenRechnungAddItem): ReturnStatus
    {
        $request = [
            'debitorenRechnungAdd' => [
                'DebitorenRechnungAddItem' => $debitorenRechnungAddItem->__toArray(),
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->debitorenRechnungAddResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Löscht eine vorhandene Debitorenrechnung
     */
    public function debitorenRechnungDelete(): ReturnStatus
    {

    }

    /**
     * Fügt ein Attachment einer Debitorenrechnung hinzu
     */
    public function debitorenRechnungAddAttachment(string $buchungId, AttachmentAddItem $attachmentAddItem): ReturnStatus
    {

    }

    /**
     * Vorlage für Filter Debitorenzahlungen
     */
    public function debitorenZahlungFilterTemplate(): DebitorenZahlungFilter
    {
        $request = [
            'debitorenZahlungFilterTemplate' => [],
        ];

        try {
            $response = $this->client->send($request);
            return DebitorenZahlungFilter::fromResponse(
                $response->debitorenZahlungFilterTemplateResponse->ReturnData->DebitorenZahlungFilter
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Auflistung Debitorenzahlungen
     */
    public function debitorenZahlungList(DebitorenZahlungFilter $filter = null): DebitorenZahlungListItemCollection
    {
        $request = [
            'debitorenZahlungList' => '',
        ];

        if ($filter instanceof DebitorenZahlungFilter) {
            $request['debitorenZahlungList'] = [
                'DebitorenZahlungFilter' => $filter->__toArray()
            ];
        }

        try {
            $response = $this->client->send($request);
            return DebitorenZahlungListItemCollection::fromResponse(
                $response->debitorenZahlungListResponse->ReturnData->DebitorenZahlungListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert Details einer Debitorenzahlung
     */
    public function debitorenZahlungGet(string $id): DebitorenZahlungItem
    {
        $request = [
            'debitorenZahlungGet' => [
                'Zahlung_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return DebitorenZahlungItem::fromResponse(
                $response->debitorenZahlungGetResponse->ReturnData->DebitorenZahlungItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Erzeugt Zahlung für Debitorenrechnung
     *
     * Es wird für einen vorhandenen Debitoren-Rechnung eine Zahlung angelegt.
     * Ablauf:
     *   1. Posten_ID ermitteln für welchen eine Zahlung angelegt werden soll( z.B. über debitorenRechnungList).
     *   2. Funktion debitorenZahlungCreate mit Parameter Posten_ID,Datum,Konto,Zahlungsart ausführen.
     *   3. Es wird eine Zahlung angelegt, Rückgabe InsertID oder Fehlerstatus.
     */
    public function debitorenZahlungCreate(string $postenId, string $date, string $konto, ZahlungsartEnum $zahlungsart = null): ReturnStatus
    {
        $request = [
            'debitorenZahlungCreate' => [
                'Posten_ID' => $postenId,
                'Datum' => $date,
                'Konto' => $konto,
            ],
        ];

        // Zahlungsart optional, default ist Angabe im Posten.
        if ($zahlungsart instanceof ZahlungsartEnum) {
            $request['debitorenZahlungCreate']['Zahlungsart'] = $zahlungsart->value;
        }

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->debitorenZahlungCreateResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Löscht eine vorhandene Debitorenzahlung
     */
    public function debitorenZahlungDelete(): ReturnStatus
    {

    }
}
