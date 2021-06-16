<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\SteuersatzListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class SteuersatzListService extends BaseService
{
    public function steuersatzList(): SteuersatzListItemCollection
    {
        $request = [
            'steuersatzList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return SteuersatzListItemCollection::fromResponse(
                $response->steuersatzListResponse->ReturnData->SteuersatzListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
