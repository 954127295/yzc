<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Sjts extends Common
{
    //数据透视
    public function index(){
    	$s_time = input('post.s_time');
    	$e_time = input('post.e_time');
    	$column = db("hardwareColumn")->select();
    	$this->assign([
            'hardwarecolumn' => $column,
        ]);

    	$td_count = count($column);
    	$td_width = 100/$td_count;
    	$this->assign("td_count",$td_count);
    	$this->assign("td_width",$td_width);

    	$c_arr = array();
    	foreach($column as $cl){
    		$c_arr[] = $cl['keys'];
    	}
    	$c_str = implode(",",$c_arr);
    	// if(!empty($s_time)){
    	// 	$where['TIME'] = array("egt",$s_time);
    	// }
    	// if(!empty($e_time)){
    	// 	$where['TIME'] = array("elt",$e_time);
    	// }
    	// if(empty($s_time) && empty($e_time)){
    	// 	$now = strtotime("-7 day");
    	// 	$where['TIME'] = array("egt",$now);
    	// }
    	$table_res = db("Hardware")->paginate(10);
    	$this->assign("table_res",$table_res);
        return view();
    }

    private function get_table_list(){
    	$column = db("hardwareColumn")->select();
    }

    public function get_zhexian_list1(){
        $type = "NP";
        $s_time = "2018-12-01 00:00:00";
        // $e_time = input("post.e_time");
        $sql = "select `TIME`,".$type." from pig_hardware where 1 = 1";

        if(!empty($s_time)){
            $sql .= " and `TIME` >= ".strtotime($s_time);
        }
        if(!empty($e_time)){
            $sql .= " and `TIME` <= ".strtotime($e_time);
        }
        if(empty($s_time) && empty($e_time)){
            $now = strtotime("-1 day");
            $to = strtotime("+1 day");
            $sql .= " and `TIME` >= ".$now." and `TIME` <= ".$to;
        }
        $result = Db::query($sql);
        $times = array();
        $values = array();
        $max = $result[0][$type];
        foreach($result as $r){
            $times[] = date("Y-m-d H:i:s",$r['TIME']);
            $values[] = $r[$type];
            if($r[$type] > $max){
                $max = $r[$type];
            }
        }
        $max = $max + 5;
        print_r($values);exit;
        echo json_encode(array("times"=>$times,"values"=>$values,"max"=>$max));
    }

    public function get_zhexian_list(){
        $type = input("post.type");
        $s_time = input("post.s_time");
        $e_time = input("post.e_time");
        $sql = "select `TIME`,".$type." from pig_hardware where 1 = 1";

    	if(!empty($s_time)){
            $sql .= " and `TIME` >= ".strtotime($s_time);
    	}
    	if(!empty($e_time)){
            $sql .= " and `TIME` <= ".strtotime($e_time);
    	}
    	if(empty($s_time) && empty($e_time)){
    		$now = strtotime("-1 day");
    		$to = strtotime("+1 day");
            $sql .= " and `TIME` >= ".$now." and `TIME` <= ".$to;
    	}
    	$result = Db::query($sql);
    	$times = array();
    	$values = array();
        $max = $result[0][$type];
    	foreach($result as $r){
    		$times[] = date("Y-m-d H:i:s",$r['TIME']);
    		$values[] = $r[$type];
            if($r[$type] > $max){
                $max = $r[$type];
            }
    	}
        $max = $max + 5;
    	echo json_encode(array("times"=>$times,"values"=>$values,"max"=>$max));
    }

}
