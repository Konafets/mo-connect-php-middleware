<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\NummernkreisListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class NummernkreisListService extends BaseService
{
    public function nummernkreisList(): NummernkreisListItemCollection
    {
        $request = [
            'nummernkreisList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return NummernkreisListItemCollection::fromResponse(
                $response->nummernkreisListResponse->ReturnData->NummernkreisListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
