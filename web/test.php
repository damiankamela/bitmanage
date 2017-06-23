<?php
require __DIR__ . '/../src/Bootstrap.php';
require 'Foo.php';

use JsonRPC\Client;
use JsonRPC\Server;

?>


<?php //$test = new Foo(); echo $test->test($_POST['block_number']) ?>

<?php
$client = new Client('http://username:password@127.0.0.1:8332/');
echo "<pre>\n";
print_r($client->getinfo()); echo "\n";
echo "Received: ".$client->getreceivedbylabel("Your Address")."\n";
echo "</pre>";

//$server = new Server();
//$server->getProcedureHandler()
//    ->withCallback('addition', function ($a, $b) {
//        return $a + $b;
//    })
//    ->withCallback('random', function ($start, $end) {
//        return mt_rand($start, $end);
//    })
//;
//
//echo $server->execute();