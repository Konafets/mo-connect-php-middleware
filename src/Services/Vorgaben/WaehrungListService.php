<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\WaehrungListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class WaehrungListService extends BaseService
{
    public function waehrungList(): WaehrungListItemCollection
    {
        $request = [
            'waehrungList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return WaehrungListItemCollection::fromResponse(
                $response->waehrungListResponse->ReturnData->WaehrungListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
