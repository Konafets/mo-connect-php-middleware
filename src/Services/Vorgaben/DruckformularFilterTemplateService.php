<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services\Vorgaben;

use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularFilter;
use ArrobaIt\MoConnectApi\Services\BaseService;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

class DruckformularFilterTemplateService extends BaseService
{
    public function druckformularFilterTemplate(): DruckFormularFilter
    {
        $request = [
            'druckformularFilterTemplate' => '',
        ];

        try {
            $response = $this->client->send($request);
            return DruckFormularFilter::fromResponse(
                $response->druckformularFilterTemplateResponse->ReturnData->DruckFormularFilter
            );
        } catch (JsonException | GuzzleException $e) {
        }
    }
}
