<?php use JsonRPC\Exception\ServerErrorException;

require __DIR__ . '/../src/Bootstrap.php'; ?>

    <form action="index.php" method="post">
        Block hash/number:<br>
        <input type="text" name="block_number"><br>
        <input type="submit" value="Get block info">
    </form>

<?php
$blockNumber = $_POST['block_number'] ?? null;

if ($blockNumber) {
    $client = new \BitManage\Client('127.0.0.1', 'username', 'password');

    try {
        $blockInfo = $client->getBlockInfo($blockNumber);
    } catch(\Whoops\Exception\ErrorException $exception) {
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