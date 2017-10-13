<?php

require 'utils.php';

use FlSouto\Sampler;
use function FlSouto\Noisemk\smp;

$files = glob("16bit/*");
shuffle($files);

$files = array_slice($files,0,rand(4,8));

$stream = smp(array_shift($files));

$normalize = rand(0,1);

foreach($files as $i => $file){	
	$smp = smp($file);
	if(rand(0,1)){
		$smp->mod('gain -'.rand(1,8));
	}
	if(rand(0,1)){
		$div = (rand(0,1)?2:4);
		$smp->cut(0,'1/'.$div);
		if(rand(0,1)){
			if(rand(0,1)){
				$smp->fade(-15,0);
			} else {
				$smp->fade(0,-15);
			}
			$smp->x($div);
		}
	}
	if(rand(0,1)){
		if(rand(0,1)){
			$smp->fade(-15,0);
		} else {
			$smp->fade(0,-15);
		}
	}
	$smp->resize($stream->len());

	if(!rand(0,5)){
		$smp->mod('reverse');
	}

	$stream->mix($smp,$normalize);
}

if($normalize){
	$stream->mod('gain 10');
}

$stream->save('output.wav');