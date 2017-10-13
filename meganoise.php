<?php

require 'utils.php';

use FlSouto\Sampler;
use function FlSouto\Noisemk\smp;

$files = glob("noise*/*.wav");
shuffle($files);

$files = array_slice($files,0,4);

$stream = smp(array_shift($files));

foreach($files as $file){
	$smp = smp($file);
	$smp->resize($stream->len());
	$stream->mix($smp,1);
}

$ambience = Sampler::select("ambience/*",true);
$ambience = $ambience->pick($stream->len());
$ambience->mod('gain -8');
$stream->mix($ambience,1);

$stream->mod('speed .5');


$stream->mod('gain 10');
$stream->save('output.wav');