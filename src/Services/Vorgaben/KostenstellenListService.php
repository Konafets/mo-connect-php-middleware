<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\KostenstelleListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class KostenstellenListService extends BaseService
{
    public function kostenstellenList(): KostenstelleListItemCollection
    {
        $request = [
            'kostenstellenList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return KostenstelleListItemCollection::fromResponse(
                $response->kostenstellenListResponse->ReturnData->KostenstelleListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
