<?php
namespace app\index\model ;

use think\Model;
use app\index\model\Day;

/**
* 学期管理
*/
class Term extends Model
{
	public function getStateTermAttr($state)
	{
		// 获取所有学期
        $status = Term::all();
		foreach ($terms as $term) 
        {
        	if ($term->state != 0)
    		{
    			$term->state = 0;
    		    $term->save();
    	    }
        }
        return $status[$state];
		
	}
    /**
     * 获取当前学期
     * @return [term][进行中的学期] 
     * @author chenzhigao <[<1641088568@qq.com>]>
     */
	static public function getCurrentTerm() {
		// 获取所有学期
        $terms = Term::all();
        foreach ($terms as $term) 
        {
        	if ($term->state != 0) {
        		return $term;
        	}
    		
        }    
	}
    /**
     * 获取当前周次
     * @param  初始化周次为0
     * @return [int]        [当前周次]
     * Author：chenzhigao <[<1641088568@qq.com>]>
     */
	public function getWeekNumByTime($time = 0) {
		$start_timestamp = strtotime('start_time');
        $current_timestamp = time();
        $day = (int)($current_timestamp - $start_timestamp)/86400;
        $time = int($day/7) + 1 ;
        return $time;
	}

    public function getDays(){
        $days = [];
        for($temp = 1 ; $temp <= 7 ; $temp ++) {
            $Day = new Day($temp , 0,$this->id);
            $Day->Day = $temp;
            array_push($days, $Day);
        }
        return $days;
    }
}