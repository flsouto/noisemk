<?php 

namespace FlSouto\Noisemk;
require 'utils.php';

$files = scan();
$files = array_slice($files,0,rand(5,20));

$mod = function($smp){
	$smp->each(rand(0,1)?.5:1,function($smp){
		$smp->mod('gain '.rand(-40,0));
		if(!rand(0,5)){
			$smp->chop(array_rand([2=>'',4=>'',8=>'']));
		}
		if(!rand(0,15)){
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

$stream = smp(array_shift($files))->to120();
$mod($stream);

foreach($files as $file){
	$smp=smp($file)->to120()->pick(4);
	$mod($smp);
	$stream->mix($smp,false);
}

$stream->cut(0,4);
$stream->x(4)->mod('speed '.(rand(6,8)/10));
$stream->save('output.wav');