<?php

namespace app\index\model;
use app\index\model\ALKonb;
/**
* 周杰
*/
class ALWeek
{
	// $term;
	// $weekTime;
	// $konbs;
	function __construct($weekTime)
	{
		$this->term = 2;
		$this->weekTime = $weekTime;
		$this->konbs = $this->makekonbs($weekTime);
    }
    public function makekonbs($weekTime)
    {
    	$konbs = [];
    	for ($konb=1; $konb <= 5; $konb++) 
    	{ 
    		$Konb = new ALkonb($konb , $weekTime);
    		array_push($konbs , $Konb);
    	}
    	return $konbs;
    	

    }
}