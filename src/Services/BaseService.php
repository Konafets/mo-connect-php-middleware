<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Services;

use ArrobaIt\MoConnectApi\Client;

class BaseService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
