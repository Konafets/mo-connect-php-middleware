<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\ZahlungsBedingungEinkaufListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ZahlungsbedingungEinkaufListService extends BaseService
{
    public function zahlungsbedingungEinkaufList(): ZahlungsBedingungEinkaufListItemCollection
    {
        $request = [
            'zahlungsbedingungEinkaufList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return ZahlungsBedingungEinkaufListItemCollection::fromResponse(
                $response->zahlungsbedingungEinkaufListResponse->ReturnData->ZahlungsBedingungEinkaufListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
