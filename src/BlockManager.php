<?php

namespace BitManage;

use JsonRPC\Exception\ServerErrorException;

class BlockManager
{
    /** @var ConnectorInterface */
    protected $connector;

    /**
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @param int $blockNumber
     * @return string
     */
    public function getBlockHash(int $blockNumber)
    {
        try {
            return $this->connector->getblockhash($blockNumber);
        } catch (ServerErrorException $exception) {
            return null;
        }
    }

    /**
     * @param string $hashOrNumber
     * @return array|null
     */
    public function getBlockInfo(string $hashOrNumber): ?array
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
            return $this->connector->getblock($hash);
        } catch (ServerErrorException $exception) {
            return null;
        }
    }

    /**
     * @param int $blockNumber
     * @return array|null
     */
    public function getBlockInfoByNumber(int $blockNumber): ?array
    {
        $hash = $this->getBlockHash($blockNumber);

        return $hash ? $this->getBlockInfoByHash($hash) : null;
    }

    /**
     * @param ConnectorInterface $connector
     */
    public function setConnector(ConnectorInterface $connector): void
    {
        $this->connector = $connector;
    }
}