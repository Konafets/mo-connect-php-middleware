<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Models\Firmen\FirmaItem;

class FirmaItemService extends BaseService
{
    public function firmaGet(): FirmaItem
    {
        $request = [
            'firmaGet' => '',
        ];

        try {
            $response = $this->client->send($request);
            return FirmaItem::fromResponse($response->firmaGetResponse->ReturnData);
        } catch (\JsonException $e) {
        }
    }
}
