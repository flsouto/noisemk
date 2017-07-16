<?php

require_once 'utils.php';

while(true){

	$files = glob("storage/*.wav");

	shuffle($files);

	$smp1 = new FlSouto\Sampler(array_shift($files));
	$smp1->cut(0, $smp1->len()/4);
	$smp1 = smp($smp1); 

	$smp2 = new FlSouto\Sampler(array_shift($files));
	$smp2->cut(0, $smp2->len()/4);
	$smp2 = smp($smp2); 

	$smp1->fade(-30,0);
	$smp2->fade(0,-30);
	$smp1->mix($smp2,false);

	if($smp1->len()!=4){
		continue;
	}

	$smp1->x(4);
	if($smp1->len()!=16){
		continue;
	}

	$smp1->save('output.wav');
	break;

}
