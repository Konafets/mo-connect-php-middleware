<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Client;
use ArrobaIt\MoConnectApi\Models\ApiInfo;

class ApiInfoService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function apiInfoGet(): ApiInfo
    {
        $request = [
            'apiInfoGet' => '',
        ];

        try {
            $info = $this->client->call($request);
            return ApiInfo::fromResponse($info->apiInfoGetResponse->ReturnData);
        } catch (\JsonException $e) {
        }
    }
}
