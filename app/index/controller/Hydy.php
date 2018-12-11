<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Hydy extends Common
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
    		$log = db("penlog")->where(array("pen_id"=>$d['id']))->order("id desc")->find();
    		//获取预计分娩日期是否超出预计时间
    		$one_time = strtotime($log['breeding_time']);
    		$two_time = time();
    		$cha_time = ($two_time - $one_time)/86400;
    		if($cha_time > 111 && $cha_time < 118){
    			$log['expected_time'] = date("Y-m-d H:i:s",strtotime("+1 day"));
    		}elseif($cha_time >= 118){
    			$log['expected_time'] = "118天未分娩";
    		}
    		$d['logs'] = $log;
    		$new_data[] = $d;
    	}
    	$this->assign("page1",$page1);
        // dump($new_data);die;
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

    //获取当前选择圈详情
    public function get_pigpen(){
    	$id = input("post.id");
    	$where['pen_id'] = $id;
    	$content = db("penlog")->where($where)->order("id desc")->find();
    	echo json_encode(array("code"=>0,"content"=>$content));
    }

    //获取统计数量：转入头数、存栏量、死亡量、数量差异、流产数量
    private function ge_num(){
    	$dyid = Session::get("dyid");
    	$data = array();
    	$data['in_num'] = db("pigpen")->where(array("dyid"=>$dyid))->count();//转入头数
    	$data['die_num'] = db("penlog")->where(array("dyid"=>$dyid,"out_reason"=>"死亡"))->count();//死亡头数
    	$data['out_num'] = db("penlog")->where(array("dyid"=>$dyid,"out_reason"=>"流产"))->count();//胎次//流产数量
        $pens = db('pigpen')->where($where)->field("id")->select();
        $data['tc'] = 0;
        foreach($pens as $d){
            $penlogs = db("penlog")->where(array("pen_id"=>$d['id']))->field("tc")->order("id desc")->find();
            $data['tc'] += $penlogs['tc'];
        }
    	return $data;
    }

    //获取怀孕单元操作记录
    private function get_log(){
    	$dyid = Session::get("dyid");
    	$where['dyid'] = $dyid;
    	$list = db("penlog")->where($where)->order("id desc")->paginate(10,false,['var_page'=>'p']);
    	return $list;
    }

    //怀孕修改
    //孕龄、预计分娩日期、转出时间
    public function update(){
		$tc = input("post.tc");
		$id = input("post.edit_id");
		$measure = input("post.measure");
		$peizhong = input("post.peizhong");
		$time = date("Y-m-d H:i:s");
		$to_time = date("Y-m-d H:i:s",strtotime("+1 day"));
		$data['expected_time'] = date("Y-m-d H:i:s",strtotime("+112 day"));
		$data['pregnancy_time'] = $to_time;
		$data['erbiao_num'] = input("post.erbiao_num");
		$data['pen_id'] = $id;
    	$dyid = Session::get("dyid");
		$data['dyid'] = $dyid;
		if($peizhong == "yes"){
			$data['breeding_time'] = $time;
		}
		$data['tc'] = $tc;
		$data['measure'] = $measure;
		$out_reason = input("post.out_reason");
		if(!empty($out_reason)){
			if($out_reason == "死亡"){
				//添加一条记录
				db("pigpen")->delete($id);
			}
			$data['out_reason'] = $out_reason;
			$data['out_time'] = $time;

		}
		db("penlog")->insert($data);
		$this->redirect("Hydy/index");
    }

}
