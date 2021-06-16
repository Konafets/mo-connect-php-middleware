<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\ZahlungsBedingungVerkaufListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class ZahlungsbedingungVerkaufListService extends BaseService
{
    public function zahlungsbedingungVerkaufList(): ZahlungsBedingungVerkaufListItemCollection
    {
        $request = [
            'zahlungsbedingungVerkaufList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return ZahlungsBedingungVerkaufListItemCollection::fromResponse(
                $response->zahlungsbedingungVerkaufListResponse->ReturnData->ZahlungsBedingungVerkaufListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
