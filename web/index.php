<?php

use BitManage\BlockManager;
use BitManage\ClientWrapper;
use BitManage\CLIWrapper;

require __DIR__ . '/../src/Bootstrap.php'; ?>

    <form action="index.php" method="post">
        Block hash/number:<br>
        <input type="text" name="block_number"><br>
        <input type="radio" name="connector_type" value="rpc" checked="checked">Json RPC<br>
        <input type="radio" name="connector_type" value="cli">CLI<br>
        <input type="submit" value="Get block info">
    </form>

<?php
$blockNumber = $_POST['block_number'] ?? null;
$connectorType = $_POST['connector_type'] ?? null;

if (!$blockNumber || !$connectorType) {
    return;
}

if ('rpc' === $connectorType) {
    $connector = new ClientWrapper('127.0.0.1', 'username', 'password');
} else {
    $connector = new CLIWrapper('/home/damian/.bitcoin');
}

$manager = new BlockManager($connector);

try {
    $blockInfo = $manager->getBlockInfo($blockNumber);
} catch (\Whoops\Exception\ErrorException $exception) {
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