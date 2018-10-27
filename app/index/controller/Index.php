<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class Index extends Common{
	public function __construct(){
		parent::__construct();
	}

    public function index(){
        $user = self::$user_arr;
        if(in_array($user['permission'],array(1,2,3))){
            $this->redirect("Index/choose");
        }elseif(in_array($user['permission'],array(4,5,6))){
            $this->redirect("Index/field");
        }else{
            $this->error("没有相关权限进入");
        }
    }

	//区域选择
    public function choose(){
        $user = self::$user_arr;
        if(!in_array($user['permission'],array(1,2,3))){
            $this->error("无权限进入");
        }else{
            $qy = db("Cwh")->distinct(true)->field("region")->select();
            $this->assign("qy",$qy);
            return $this->fetch();
        }
    }

    //获取省份
    public function get_sf(){
        $request = Request::instance();
        $qy = $request->post("qy");
        $where['region'] = $qy;
        $list = db("Cwh")->distinct(true)->where($where)->field("province")->select();
        echo json_encode(array("code"=>0,"list"=>$list));
    }

    //获取子公司
    public function get_zgs(){
        $request = Request::instance();
        $sf = $request->post("sf");
        $where['province'] = $sf;
        $list = db("Cwh")->distinct(true)->where($where)->field("zgs")->select();
        echo json_encode(array("code"=>0,"list"=>$list));
    }

    //获取猪场
    public function get_zc(){
        $request = Request::instance();
        $zgs = $request->post("zgs");
        $where['zgs'] = $zgs;
        $list = db("Cwh")->distinct(true)->where($where)->field("xmname")->select();
        echo json_encode(array("code"=>0,"list"=>$list));
    }

    //选择需进入的猪场
    public function find_zc(){
        $info = input('post.');
        $res = db("Cwh")->where($info['info'])->field("id")->find();
        $this->redirect("Zc/index",array("id"=>$res['id']));
    }

}
