<?php

use BitManage\ViewRenderer;

require __DIR__ . '/../src/Bootstrap.php'; ?>

    <form action="index.php" method="post">
        Block hash/number:<br>
        <input type="text" name="block_number"><br>
        <input type="radio" name="connector_type" value="rpc" checked="checked">Json RPC<br>
        <input type="radio" name="connector_type" value="cli">CLI<br>
        <input type="submit" value="Get block info">
    </form>

<?php
$renderer = new ViewRenderer();
$renderer->renderView();