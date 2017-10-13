<?php

require 'utils.php';


$track = FlSouto\Sampler::select(["meganoise*/*","noise*/*"]);

$div = 32 * rand(1,2);
$st = rand(1,$div/2);
$len = array_rand([1=>'',2=>'',4=>'']);

$track->cut("$st/$div","$len/$div")->x(16);
$track->save('output.wav');