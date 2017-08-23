<?php

require '../flsouto/drum-machine/vendor/autoload.php';

define('GUIT_DIV_MAX', rand(1,2));

function addbkg($track){

	$bkgs = array_merge(glob("/home/fabio/Downloads/guitar/*.ogg"));

	shuffle($bkgs);
	$bkg_file = current($bkgs);
	$bkg = new FlSouto\Sampler($bkg_file);
	$bkg = $bkg->pick(2);
	$bkg->cut(0,$track->len()/rand(1,GUIT_DIV_MAX));
	$bkg->mod('overdrive 6 reverb pitch -50');
	$track->mix($bkg,false);

}

$dm = new FlSouto\DrumMachine();
$dm->len(rand(0,1)?.16:.32);
$dm->snare('3a');
$dm->kick('2',rand(1,3));
$dm->ride('*',array_rand([4=>'',8=>'',16=>'']));

if(rand(0,1)){
	$dm->void(1);
}

$cb = function($s,$k){
	if(!rand(0,5) && $k=='k'){
		return $s()->chop(rand(2,3));
	}
};

$rmin = 2;
$rmax = 5;

if(rand(0,1)){
	$r = rand(3,5);
	$rmin = $rmax = $r;
}

$seq1 = $dm->mkseq(rand($rmin,$rmax), '?');
$seq2 = $dm->mkseq(rand($rmin,$rmax), '?');
$seq3 = $dm->mkseq(rand($rmin,$rmax), '?');
$seq4 = $dm->mkseq(rand($rmin,$rmax), '?');
$seq5 = $dm->mkseq(rand($rmin,$rmax), '?');
$seq6 = str_replace('_','',$dm->mkseq(rand($rmin,$rmax), '?'));

$seq1 = $dm->render($seq1,$cb);
$seq2 = $dm->render($seq2,$cb);
$seq3 = $dm->render($seq3,$cb);
$seq4 = $dm->render($seq4,$cb);
$seq5 = $dm->render($seq5,$cb);
$seq6 = $dm->render($seq6,$cb);

addbkg($seq1);
addbkg($seq2);
addbkg($seq3);
addbkg($seq4);
addbkg($seq5);
addbkg($seq6);

$part1 = $seq1()->add($seq2)->add($seq1)->add($seq3)->add($seq1)->add($seq2)->add($seq1)->add($seq4);
$part2 = $seq1()->add($seq2)->add($seq1)->add($seq3)->add($seq1)->add($seq2)->add($seq1)->add($seq5);
$part3 = $seq1()->add($seq2)->add($seq1)->add($seq3)->add($seq1)->add($seq2)->add($seq1)->add($seq6);

$track = $part1()->add($part2)->add($part1)->add($part3);

$track->save('output.wav');