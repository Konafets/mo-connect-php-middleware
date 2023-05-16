<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Buchungen;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungAddItem;
use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungFilter;
use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungItem;
use ArrobaIt\MoConnectApi\Models\Buchungen\Collections\BuchungenListItemCollection;
use ArrobaIt\MoConnectApi\Models\Http\ReturnStatus;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class BuchungenService extends BaseService
{

    /**
     * Vorlage für Buchung-Filter
     */
    public function buchungFilterTemplate(): BuchungFilter
    {
        $request = [
            'buchungFilterTemplate' => '',
        ];

        try {
            $response = $this->client->send($request);

            return BuchungFilter::fromResponse($response->buchungFilterTemplateResponse->ReturnData->BuchungFilter);
        } catch (JsonException|GuzzleException $e) {

        }
    }

    /**
     * Listet alle Buchungen
     */
    public function buchungList(BuchungFilter $filter = null): BuchungenListItemCollection
    {
        $request = [
            'buchungList' => [
                'BuchungenFilter' => '',
            ],
        ];

        if ($filter instanceof BuchungFilter) {
            $request['buchungList']['BuchungenFilter'] = $filter->__toArray();
        }

        try {
            $response = $this->client->send($request);
            return BuchungenListItemCollection::fromResponse($response->buchungListResponse->ReturnData->BuchungListItem);
        } catch (JsonException|GuzzleException $e) {

        }
    }

    /**
     * Liefert Eigenschaften einer Buchung
     */
    public function buchungGet(string $id): BuchungItem
    {
        $request = [
            'buchungGet' => [
                'Buchung_ID' => $id
            ],
        ];

        try {
            $response = $this->client->send($request);
            return BuchungItem::fromResponse(
                $response->buchungGetResponse->ReturnData->BuchungItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Liefert BuchungAddItem als Vorlage
     */
    public function buchungTemplate(int $positionCount): BuchungAddItem
    {
        $request = [
            'buchungTemplate' => [
                'Positionenanzahl' => $positionCount
            ],
        ];

        try {
            $response = $this->client->send($request);
            return BuchungAddItem::fromResponse(
                $response->buchungTemplateResponse->ReturnData->BuchungAddItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Fügt neue Buchung hinzu
     *
     * Hinweis: Standardbuchungen enthalten EIN BuchungPositionAddItem
     * Mehrere BuchungPositionAddItem werden für Splitt-Buchungen verwendet
     */
    public function buchungAdd(BuchungAddItem $buchungAddItem): ReturnStatus
    {
        $request = [
            'buchungAdd' => [
                'BuchungAddItem' => $buchungAddItem->__toArray(),
            ],
        ];

        try {
            $response = $this->client->send($request);
            return ReturnStatus::fromResponse(
                $response->buchungAddResponse->ReturnData->ReturnStatus
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }

    /**
     * Fügt ein Attachment einer Buchung hinzu
     */
    public function buchungAddAttachment(string $buchungId, AttachmentAddItem $attachmentAddItem): ReturnStatus
    {

    }
}
