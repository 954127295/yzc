<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Bydy extends Common
{
    // 保育单元信息
    public function index(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$data = db('pigpen')->where($where)->paginate(10,false,['var_page'=>'np']);
    	$page1 = $data->render();
    	$data = $data->all();
    	$new_data = array();
    	foreach($data as $d){
    		$log = db("baolog")->where(array("pen_id"=>$d['id']))->order("id desc")->find();
    		$d['logs'] = $log;
    		$new_data[] = $d;
    	}
    	$this->assign("page1",$page1);
        $this->assign([
            'info' => $new_data,
        ]);
        $log = $this->get_log();
        $page2 = $log->render();
        $log = $log->all();
        $new_list = array();
        foreach($log as $li){
            $pigpen = db("pigpen")->where(array("id"=>$li['pen_id']))->field("jnumber")->find();
            $li['jnumber'] = $pigpen['jnumber'];
            $new_list[] = $li;
        }
    	$this->assign("page2",$page2);
        $this->assign([
            'log' => $new_list,
        ]);
        $num = $this->ge_num();
        $this->assign([
            'num' => $num,
        ]);
        return view();
    }

    //获取统计数量
    private function ge_num(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$data = db('pigpen')->where($where)->field("id")->select();
    	$num = array();
        $current_weight = 0;
        $in_date_year = 0;
        $in_heavy = 0;
        $time = time();
        $out_num = 0;
        $in_date = 0;
    	foreach($data as $d){
    		$res = db("baolog")->where(array("pen_id"=>$d['id']))->field("in_num,die_num,current_weight,in_date_year,out_num,put_time,in_heavy")->order("id desc")->find();
    		$num['in_num'] += $res['in_num'];//转入头数
            $num['cunlan'] += $res['in_num'] - $res['die_num'];//存栏量
            $num['die_num'] += $res['die_num'];//死亡量
            $current_weight += $res['current_weight'];
            $in_date_year += $res['in_date_year'];
            $in_date += ($time - $res['put_time'])/86400;
            $out_num += $res['out_num'];
            $num['amount'] += $res['amount'];//饲料量
            $in_heavy += $res['in_heavy'];
    	}
        @$num['ok_lv'] = $this->rounds(($data['in_num']-$data['die_num'])/$data['in_num']);//成活率
        @$num['current_weight'] = $this->rounds($current_weight/$data['cunlan']);//当前均重
        $num['current_date_year'] = ceil($in_date);//当前日龄
        @$num['day_weight'] = $this->rounds(($current_weight/$num['cunlan'])/$in_date);//日增重
        $cha_num = $num['in_num'] - $num['die_num'] - $out_num;
        $num['cha_num'] = $cha_num != 0?"<a style='color:red;'>".$cha_num."</a>":0;//数量差异
        @$num['conversion'] = $this->rounds($num['amount']/($current_weight - $in_heavy));//料肉比
    	return $num;
    }

    private function rounds($num){
        return sprintf("%.2f",$num);
    }

    //获取哺育单元操作记录
    private function get_log(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$list = db("baolog")->where($where)->order("id desc")->paginate(10,false,['var_page'=>'p']);
    	return $list;
    }

    //哺育修改
    public function update(){
		$id = input("post.edit_id");
		$in_date_year = input("post.in_date_year");
		$current_date_year = input("post.current_date_year");
		$in_heavy = input("post.in_heavy");
		$current_weight = input("post.current_weight");
		$in_num = input("post.in_num");
		$die_num = input("post.die_num");
		$out_num = input("post.out_num");
		$batch = input("post.batch");
        $amount = input("post.amount");
		$time = date("Y-m-d H:i:s");
		if(!empty($out_num)){
			$out_time = $time;
		}
        if(!empty($current_weight)){
            @$conversion = sprintf("%.2f",($current_weight - $in_heavy)/$amount);
        }
		$data['put_time'] = time();
        $p_log = db("baolog")->where(array("pen_id"=>$id))->order("id desc")->limit("0,1")->field("current_weight,put_time")->find();
        if(!empty($current_weight)){
            $cha_time = ($data['put_time'] - $p_log['put_time'])/86400;
            @$total_weight = sprintf("%.2f",($current_weight - $p_log['current_weight'])/$cha_time);
        }
        $data['pen_id'] = $id;
        $dyid = Session::get("dyid");
        $data['dyid'] = $dyid;
        $data['batch'] = $batch;
        $data['in_num'] = $in_num;
        $data['in_heavy'] = $in_heavy;
        $data['in_date_year'] = $in_date_year;
        $data['out_time'] = $out_time;
        $data['out_num'] = $out_num;
        $data['current_weight'] = $current_weight;
        $data['die_num'] = $die_num;
        $data['current_date_year'] = $current_date_year;
        $data['conversion'] = $conversion;
        $data['amount'] = $amount;
        $data['total_weight'] = $total_weight;
		db("baolog")->insert($data);
		$this->redirect("Bydy/index");
    }
}
