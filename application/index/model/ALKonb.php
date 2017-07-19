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
	function __construct($konbName , $weekTime , $userName , $termId)
	{
        $this->termId = $termId;
        $this->userName = $userName;
		$this->konbName = $konbName;
		$this->weekTime = $weekTime;
		$this->Days = $this->makeDays($konbName , $weekTime ,$userName , $termId);
    }
    public function makeDays($konbName , $weekTime ,$userName , $termId)
    {
    	$Days = [];
    	for ($day=1; $day <=7 ; $day++) 
    	{ 
    		$Day = new ALDay($konbName , $weekTime , $day ,$userName , $termId);
    		array_push($Days, $Day);
    	}
    	return $Days;
    }
}