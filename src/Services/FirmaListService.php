<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Models\Firmen\FirmaListItem;
use ArrobaIt\MoConnectApi\Models\Firmen\FirmaListItems;

class FirmaListService extends BaseService
{
    public function firmaList(): FirmaListItems
    {
        $request = [
            'firmaList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return FirmaListItems::fromResponse($response->firmaListResponse->ReturnData);
        } catch (\JsonException $e) {
        }
    }
}
