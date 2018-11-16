<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Pydy extends Common
{
    // 单元监控
    public function index(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$data = db('pigpen')->where($where)->paginate(10,false,['var_page'=>'np']);
    	$page1 = $data->render();
    	$data = $data->all();
    	$new_data = array();
    	foreach($data as $d){
    		$log = db("bylog")->where(array("pen_id"=>$d['id']))->order("id desc")->find();
    		$d['logs'] = $log;
    		$new_data[] = $d;
    	}
    	$this->assign("page1",$page1);
        $this->assign([
            'data' => $new_data,
        ]);
        $log = $this->get_log();
        $page2 = $log->render();
        $log = $log->all();
    	$this->assign("page2",$page2);
        $this->assign([
            'log' => $log,
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
    	$num['in_num'] = db("pigpen")->where(array("dyid"=>$dyid))->count();//转入头数
        $bycount = db("bylog")->where(array("dyid"=>$dyid,"status"=>"母猪死亡"))->count();
        $num['mother_cunlan'] = $num['in_num'] - $bycount;//母猪存栏量
        $num['mother_die'] = $bycount;//母猪死亡量
        $bycount_c = db("bylog")->where(array("dyid"=>$dyid,"status"=>"母猪转出"))->count();
        $mother_cha = $num['in_num'] - $bycount - $bycount_c;
        $num['mother_cha'] = $mother_cha != 0?"<a style='color:red;'>".$mother_cha."</a>":0;//母猪差异
        foreach($data as $d){
            $res = db("bylog")->where(array("pen_id"=>$d['id']))->field("")->order("id desc")->find();
            $num['children_die_num'] += $res['children_die_num'];//仔猪死亡量
            $num['health_num'] += $res['health_num'];//健仔
            $num['die_num'] += $res['die_num'];//死胎
            $num['weak_num'] += $res['weak_num'];//弱仔
            $num['deformity_num'] += $res['deformity_num'];//畸形
            $num['children_out_num'] += $res['children_out_num'];
            $num['tc'] += $res['tc'];//胎次

        }
        $num['children_all_num'] = $res['health_num'] - $res['children_die_num'];//仔猪存栏量
        @$num['children_ok_rate'] = ($num['health_num']-$num['die_num'])/$num['health_num'];//存活率
        $children_cha = $num['health_num'] - $num['children_out_num'];
        $num['children_cha'] = $children_cha != 0?"<a style='color:red;'>".$children_cha."</a>":0;//仔猪差异
    	return $num;
    }

    //获取哺育单元操作记录
    private function get_log(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$list = db("bylog")->where($where)->order("id desc")->paginate(10,false,['var_page'=>'p']);
    	return $list;
    }

    //哺育修改
    public function update(){
		$tc = input("post.tc");
		$id = input("post.edit_id");
		$erbiao_num = input("post.erbiao_num");
		$health_num = input("post.health_num");
		$die_num = input("post.die_num");
		$mummy_num = input("post.mummy_num");
		$weak_num = input("post.weak_num");
		$deformity_num = input("post.deformity_num");
		$children_die_num = input("post.children_die_num");
		$fenmian = input("post.fenmian");
		$children_out_num = input("post.children_out_num");
		$status = input("post.status");
		$time = date("Y-m-d H:i:s");
		if(!empty($fenmian)){
			$delivery_time = $time;
			$date_year = $time;
		}
		$all_num = $health_num + $die_num + $mummy_num + $weak_num + $deformity_num;
		if($status == "母猪转出"){
			$mother_out_time = $time;
		}
		$children_all_num = $health_num - $die_num - $children_out_num;
		if($children_all_num == 0){
			$children_out_time = $time;
		}
		@$children_ok_rate = ($health_num - $die_num)/$health_num;
		$data['pen_id'] = $id;
    	$dyid = Session::get("dyid");
		$data['dyid'] = $dyid;
		$data['tc'] = $tc;
		$data['erbiao_num'] = $erbiao_num;
		$data['health_num'] = $health_num;
		$data['die_num'] = $die_num;
		$data['mummy_num'] = $mummy_num;
		$data['weak_num'] = $weak_num;
		$data['deformity_num'] = $deformity_num;
		$data['children_die_num'] = $children_die_num;
		$data['children_out_num'] = $children_out_num;
		$data['status'] = $status;
		$data['delivery_time'] = $delivery_time;
		$data['date_year'] = $date_year;
		$data['all_num'] = $all_num;
		$data['mother_out_time'] = $mother_out_time;
		$data['children_all_num'] = $children_all_num;
		$data['children_out_time'] = $children_out_time;
		$data['children_ok_rate'] = $children_ok_rate;
		db("bylog")->insert($data);
		$this->redirect("Pydy/index");
    }

}
