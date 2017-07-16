<?php

$config = require 'config.php';

define('DOWNLOADS_DIR', $config['downloads_dir']);

require $config['sampler_dir'].'/FlSouto/Sampler.php';

use FlSouto\Sampler;

function get_files($max=null){

	$files = [];

	foreach(scandir(DOWNLOADS_DIR) as $file){
		if(stristr($file,'looperman') && stristr($file,'.wav')){
			$file = DOWNLOADS_DIR.'/'.$file;
			$files[filemtime($file)] = $file;
		}
	}

	krsort($files);

	if($max){
		$files = array_slice($files,0,$max);
	}

	return $files;

}


function smp($file, $force120 = true){

	if(!$file instanceof Sampler){
		$smp = new Sampler($file);
	} else {
		$smp = $file;
	}
	$len = $smp->len();

	if(in_array($len,[4,8,16,32])){
		return $smp;
	}

	if($len==12){
		$smp->resize(rand(0,1)?8:16);
	} else {

		$closest = null;
		$lastdiff = 999;

		foreach([4,8,16,32] as $time){
			$diff = abs($time-$len);
			if($diff < $lastdiff){
				$lastdiff = $diff;
				$closest = $time;
			}
		}

		$smp->resize($closest);

	}

	return $smp;


}