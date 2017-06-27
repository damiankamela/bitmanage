<?php

namespace BitManage;

use JsonRPC\Client;

/**
 * @method string getblockhash(int $number)
 * @method array getblock(string $hash)
 */
class ClientWrapper extends Client implements ConnectorInterface
{
    /** @var \JsonRPC\Client */
    protected $client;

    /**
     * @param string $ip
     * @param string $username
     * @param string $password
     * @param string $port
     */
    public function __construct(string $ip, string $username, string $password, string $port = '8332')
    {
        $url = sprintf('http://%s:%s@%s:%s/', $username, $password, $ip, $port);

        parent::__construct($url, false, null);
    }
}