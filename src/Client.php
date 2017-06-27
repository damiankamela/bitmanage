<?php

namespace BitManage;

use JsonRPC\Exception\ServerErrorException;

class Client
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
        $this->client = new \JsonRPC\Client($url, false, null);
    }

    /**
     * @param int $blockNumber
     * @return string
     */
    public function getBlockHash(int $blockNumber)
    {
        try {
            return $this->client->getblockhash($blockNumber);
        } catch (ServerErrorException $exception) {
            return null;
        }
    }

    /**
     * @param string $hashOrNumber
     * @return array|mixed|null
     */
    public function getBlockInfo(string $hashOrNumber)
    {
        $info = $this->getBlockInfoByHash($hashOrNumber);

        if($info) {
            return $info;
        }
        return is_numeric($hashOrNumber) ? $this->getBlockInfoByNumber(intval($hashOrNumber)) : null;
    }

    /**
     * @param string $hash
     * @return mixed
     */
    public function getBlockInfoByHash(string $hash)
    {
        try {
            return $this->client->getblock($hash);
        } catch (ServerErrorException $exception) {
            return null;
        }
    }

    /**
     * @param int $blockNumber
     * @return array
     */
    public function getBlockInfoByNumber(int $blockNumber)
    {
        $hash = $this->getBlockHash($blockNumber);

        return $hash ? $this->getBlockInfoByHash($hash) : null;
    }
}