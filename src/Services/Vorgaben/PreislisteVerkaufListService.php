<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\Collections\VerkaufpreislisteListItemCollection;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class PreislisteVerkaufListService extends BaseService
{
    public function preislisteVerkaufList(): VerkaufpreislisteListItemCollection
    {
        $request = [
            'preislisteVerkaufList' => '',
        ];

        try {
            $response = $this->client->send($request);
            return VerkaufpreislisteListItemCollection::fromResponse(
                $response->preislisteVerkaufListResponse->ReturnData->VerkaufpreislisteListItem
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
