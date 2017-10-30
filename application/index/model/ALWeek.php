<?php

namespace app\index\model;
use app\index\model\ALKonb;
/**
* 周杰
*/
class ALWeek
{
    // $userName;
	// $term;
	// $weekTime;
	// $konbs;
    // $termId;
	function __construct($weekTime , $userName , $termId)
	{
        $this->termId = $termId;
        $this->userName = $userName;
		$this->term = 2;
		$this->weekTime = $weekTime;
		$this->konbs = $this->makekonbs($weekTime , $userName , $termId);
    }
    public function makekonbs($weekTime , $userName , $termId)
    {
    	$konbs = [];
    	for ($konb=1; $konb <= 5; $konb++) 
    	{ 
    		$Konb = new ALkonb($konb , $weekTime , $userName , $termId);
    		array_push($konbs , $Konb);
    	}
    	return $konbs;
    	

    }
}