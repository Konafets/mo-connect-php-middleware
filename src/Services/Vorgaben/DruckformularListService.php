<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\DruckFormularListItemCollection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularFilter;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;

class DruckformularListService extends BaseService
{
    public function druckformularList(DruckFormularFilter $filter = null): DruckFormularListItemCollection
    {
        $request = [
            'druckformularList' => '',
        ];

        if ($filter !== null) {
            $request['druckformularList'] = $filter;
        }

        try {
            $response = $this->client->send($request);
            return DruckFormularListItemCollection::fromResponse(
                $response->druckformularListResponse->ReturnData->DruckFormularListItem
            );
        } catch (\JsonException | GuzzleException $e) {
        }
    }
}
