<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Client;
use ArrobaIt\MoConnectApi\Models\ApiInformation\ApiInfo;
use GuzzleHttp\Exception\GuzzleException;

class ApiInfoService extends BaseService
{
    public function apiInfoGet(): ApiInfo
    {
        $request = [
            'apiInfoGet' => '',
        ];

        try {
            $response = $this->client->send($request);
            return ApiInfo::fromResponse($response->apiInfoGetResponse->ReturnData);
        } catch (\JsonException | GuzzleException $e) {
        }
    }
}
