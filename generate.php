<?php

$num = $argv[1];

if(!ctype_digit($num)){
	die("Usage: command <NUM>");
}

shell_exec("rm output/*.wav");

$patterns = ['pattern3.php'];

$hashes = [];

for($i=1;$i<=$num;$i++){

	$pattern = $patterns[array_rand($patterns)];
	shell_exec("php $pattern");
	$hash = md5(file_get_contents("output.wav"));
	if(isset($hashes[$hash])){
		continue;
	}
	shell_exec("mv output.wav output/loop$i.wav");
	$hashes[$hash] = 1;

}