<?php

$usage = "Usage: command <TARGET_DIR> <HOST> [DESTINATION_DIR]\n";

if(empty($argv[1])||empty($argv[2])){
    die($usage);
}

$params = [
    'target_dir' => realpath($argv[1]),
    'destination_dir' => isset($argv[3]) ? realpath($argv[3]) : null
];

file_put_contents(__DIR__.'/webcycle/params.json', json_encode($params, true));

$host = $argv[2];

passthru("php -S $host -t webcycle");