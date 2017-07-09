<?php

$num = $argv[1];

if(!ctype_digit($num)){
	die("Usage: command <NUM>");
}

$patterns = ['pattern1.php'];

for($i=1;$i<=$num;$i++){

	$pattern = $patterns[array_rand($patterns)];
	shell_exec("php $pattern && mv output.wav output/loop$i.wav");

}