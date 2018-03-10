<?php

namespace BitManage;

use Whoops\Exception\ErrorException;

class ViewRenderer
{
    public function renderView(): void
    {
        $blockNumber = $_POST['block_number'] ?? null;
        $connectorType = $_POST['connector_type'] ?? null;

        if (!$blockNumber || !$connectorType) {
            return;
        }

        $connector = $this->getConnector($connectorType);
        $manager = new BlockManager($connector);

        try {
            $blockInfo = $manager->getBlockInfo($blockNumber);
        } catch (ErrorException $exception) {
            echo $exception->getMessage();

            return;
        }

        if (is_null($blockInfo)) {
            echo "Block not found.";
        } else {
            foreach ($blockInfo as $name => $value) {
                if (is_array($value)) {
                    continue;
                }

                echo sprintf('<b>%s:</b> %s<br>', $name, $value);
            }
        }
    }

    /**
     * @param string $type
     * @return ConnectorInterface
     */
    protected function getConnector(string $type): ConnectorInterface
    {
        if ('rpc' === $type) {
            return $connector = new ClientWrapper(Config::get('ip'), Config::get('username'), Config::get('password'));
        } else {
            return $connector = new CLIWrapper(Config::get('bitcoin_data_dir'));
        }
    }
}