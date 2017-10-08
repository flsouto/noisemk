<?php

if(empty($argv[1])||empty($argv[2])){
	die("Usage: command <dir> <prefix>\n");
}

$dir = $argv[1];

if(!is_dir($dir)){
	die("Invalid directory: $dir\n");
}

$prefix = $argv[2];

$tmps =[];
foreach(glob($dir."/*.wav") as $i => $file){
	$tmp = "$dir/_tmp$i.wav";
	shell_exec("mv $file $tmp");
	$tmps[] = $tmp;
}

foreach($tmps as $i=>$tmp){
	shell_exec("mv $tmp $dir/$prefix{$i}.wav");
}

