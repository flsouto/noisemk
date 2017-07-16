<?php

require_once 'utils.php';

// GENERATES LOOPS USINGS SAMPLES

$files = glob("samples/*.wav");

shuffle($files);

$files = array_slice($files,0,rand(5,10));

$mod = function($smp){
	$smp->each(rand(0,1)?.5:1,function($smp){
		$smp->mod('gain '.rand(-40,0));
		if(!rand(0,15)){
			$smp->chop(rand(0,1)?4:8);
		}
		if(!rand(0,5)){
			$smp->mod('reverse');
		}
		if(!rand(0,5)){
			$smp->mod('reverb');
		}
		if(!rand(0,5)){
			$smp->fade(0,-15);
		}

	});
};

$stream = smp(array_shift($files));
$mod($stream);

foreach($files as $file){
	$smp=smp($file);
	$mod($smp);
	$stream->mix($smp,false);
}


$stream->mod('speed '.(rand(6,8)/10));
$stream->x(4);
$stream->save('output.wav');
//$stream->play();