<?php 

require 'utils.php';

$files = get_files(200);
shuffle($files);

$file = array_slice($files,0,rand(5,10));

$mod = function($smp){
	$smp->each(1,function($smp){
		$smp->mod('gain '.rand(-30,0));
		if(!rand(0,5)){
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
	$smp=smp($file)->cut(0,4);
	$mod($smp);
	$stream->mix($smp,rand(0,1));
}


$stream->cut(0,4);
$stream->x(4)->mod('speed '.(rand(6,8)/10));
$stream->save('output.wav');



