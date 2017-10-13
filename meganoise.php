<?php

require 'inshovoid/utils.php';

use FlSouto\Sampler;

$files = glob("noise*/*.wav");
shuffle($files);

$files = array_slice($files,0,4);

$stream = smp(array_shift($files));

foreach($files as $file){
	$smp = smp($file);
	$smp->resize($stream->len());
	$stream->mix($smp,1);
}

$ambience = new Sampler("ambience/1.mp3",true);
$ambience = $ambience->pick($stream->len());
$ambience->mod('gain -8');
$stream->mix($ambience,1);

$stream->mod('speed .5');

$track = new Sampler("/home/fabio/Downloads/InTheShadowOfTheVoidReverb.mp3");
$track->pick($stream->len(),true);
//$stream->mix($track,1);

$stream->mod('gain 10');
$stream->save('output.wav');