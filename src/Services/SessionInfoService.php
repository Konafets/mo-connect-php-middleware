<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Models\ApiInformation\ApiInfo;
use ArrobaIt\MoConnectApi\Models\ApiInformation\ApiSessionInfo;
use GuzzleHttp\Exception\GuzzleException;

class SessionInfoService extends BaseService
{
    public function apiSessioninfoGet(): ApiSessionInfo
    {
        $request = [
            'apisessioninfoGet' => '',
        ];

        try {
            $response = $this->client->send($request);
            return ApiSessionInfo::fromResponse($response->apisessioninfoGetResponse->ReturnData);
        } catch (\JsonException | GuzzleException $e) {
        }
    }
}
