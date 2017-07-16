<?php

// GENERATES SAMPLES OF 4 SECS OUT OF STORAGE

require 'utils.php';

use FlSouto\Sampler;

$files = glob(__DIR__."/storage/*.wav");

shuffle($files);

$smp = smp(array_shift($files))->cut(rand(0,7),.5);
$smp->x(8)->fade(0,-20);
$smp->save('output.wav');

