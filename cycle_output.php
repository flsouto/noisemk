<?php 

if(empty($argv[1])){
	$max = 9999999;
} else {
	$max = $argv[1];
	if(!ctype_digit($max)){
		die("Usage: command <MAX> [RAND]\n");
	}
}

$rand = false;
if(!empty($argv[2])){
	$rand = true;
}

$files = [];

foreach(scandir($dir=__DIR__.'/output/') as $file){
	if(stristr($file,'.wav')){
		$file = $dir.'/'.$file;
		$files[filemtime($file)] = $file;
	}
}

krsort($files);

$files = array_slice($files,0,$max);
$stdin = fopen("php://stdin","r");

while(true){

	if(empty($files)){
		echo "Done.\n";
		break;
	}

	if($rand){
		shuffle($files);
	}

	echo PHP_EOL;
	echo " ============= OPTIONS ====================\n";
	echo "|\n";
	echo "|  rm + ENTER : remove this loop\n";
	echo "|  st + ENTER : move to storage\n";
	echo "|  sm + ENTER : move to samples\n";
	echo "|  fn + ENTER : move to final\n";
	echo "|  just ENTER : play next loop\n";
	echo "|\n";
	echo " ==========================================\n";
	echo PHP_EOL;

	foreach($files as $i => $file){

		exec("play $file > /dev/null 2>&1 &");

		$input = trim(fgets($stdin));
		$line = current(explode("\n",`ps aux | grep play`));
		if(strstr($line,'.wav')){
			preg_match("/(\d{3,})/",$line,$match);
			shell_exec("kill ".$match[0]);
			sleep(1);
		}

		if($input=='rm'){
			shell_exec("rm $file");
			unset($files[$i]);
		}

		else if($input=='st'){
			$dest = __DIR__.'/storage/'.time().'.wav';
			shell_exec("mv $file $dest");
			unset($files[$i]);
		}
		else if($input=='sm'){
			$dest = __DIR__.'/samples/'.time().'.wav';
			shell_exec("mv $file $dest");
			unset($files[$i]);
		}
		else if($input=='fn'){
			$dest = __DIR__.'/final/'.time().'.wav';
			shell_exec("mv $file $dest");
			unset($files[$i]);
		}
	}

}


