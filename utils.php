<?php

namespace FlSouto\Noisemk;

class Data{
	static $config = [];
}

Data::$config = require 'config.php';

require Data::$config['sampler_dir'].'/FlSouto/Sampler.php';

function scan(){

	$files = [];

	foreach(Data::$config['input_paths'] as $path){
		$files = array_merge($files, glob($path));
	}

	shuffle($files);

	return $files;

}

function smp($path){
	$smp = new \FlSouto\Sampler($path);
	return $smp->mod('rate 44100');
}