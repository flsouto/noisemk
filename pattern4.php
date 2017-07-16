<?php

require 'utils.php';

use FlSouto\Sampler;

$files = glob(__DIR__."/samples/*.wav");

shuffle($files);

$smp1 = smp(array_shift($files));
//$s102 = $smp1->copy(0,2)->chop(rand(0,1)?4:8)->fade(0,-30);
$s102 = Sampler::silence(2);
$s124 = $smp1->copy(2,2)->mod('speed .5')->cut(0,2)->fade(-10,0);

$smp1 = $s102->add($s124);

$smp2 = smp(array_shift($files));
$smp2->cut(0,4)->mod('speed .5')->cut(0,4);
$smp2->fade(-30,0);


$smp2->mix($smp1,false)->x(4);
$smp3 = smp(array_shift($files));
$smp3->cut(0,4)->resize(16)->fade(-10, -5);
$smp2->mix($smp3,false);
$smp2->mod('speed .8 gain 5');


$smp2->play();