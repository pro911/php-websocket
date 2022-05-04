<?php
declare(strict_types=1);
require './vendor/autoload.php';

$data = [
    "178.236.40.224:6001/main?chang_ci=2552",
    "178.236.40.224:6001/main?chang_ci=2551"
];

function onTasks(array $data)
{
    foreach ($data as $k=>$v) {
        onTask(strval($k),$v);
    }
}
onTasks($data);

function onTask(string $tag = "1",string $url = '')
{
    if (empty($url)) return "";
    $client = new WebSocket\Client(sprintf("ws://%s",$url));

    while (true) {
        try {
            $message = $client->receive();
            echo sprintf("【%s】%s ".PHP_EOL.PHP_EOL,$tag,$message);
        }catch (\WebSocket\ConnectionException $e) {
            echo sprintf("【%s】errorCode:%s,errorMsg:%s".PHP_EOL.PHP_EOL,$tag,$e->getCode(),$e->getMessage());
        }
    }

    $client->close();
}

