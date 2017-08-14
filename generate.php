<?php

$script = $argv[1] ?? null;
$num = $argv[2] ?? null;
$destin = $argv[3] ?? null;

$error = false;

if(empty($script)||!file_exists($script)){
	$error = "Provide a valid path for <SCRIPT>";
}

else if(!ctype_digit($num)){
	$error = "Provide a digit for <NUM>";
}

else if(empty($destin)||!is_dir($destin)){
	$error = "Provide a valid direcotry for <DESTINATION>";
}

if($error){
	echo $error."\n";
	die("Usage: command <SCRIPT> <NUM> <DESTINATION>\n");
}

$hashes = [];

for($i=1;$i<=$num;$i++){

	shell_exec("php $script");

	$hash = md5(file_get_contents("output.wav"));
	if(isset($hashes[$hash])){
		continue;
	}
	shell_exec("mv output.wav $destin/".time().".wav");
	$hashes[$hash] = 1;

}