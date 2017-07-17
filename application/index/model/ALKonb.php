<?php
namespace app\index\model;
use app\index\model\ALDay;
/**
* 周杰
*/
class ALKonb
{
	// $konbName;
	// $weekTime;
	// $Days;
	function __construct($konbName , $weekTime)
	{
		$this->konbName = $konbName;
		$this->weekTime = $weekTime;
		$this->Days = $this->makeDays($konbName , $weekTime);
    }
    public function makeDays($konbName , $weekTime)
    {
    	$Days = [];
    	for ($day=1; $day <=7 ; $day++) 
    	{ 
    		$Day = new ALDay($konbName , $weekTime , $day);
    		array_push($Days, $Day);
    	}
    	return $Days;
    }
}