<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class Zc extends Common{
	public function __construct(){
		parent::__construct();
        //判断是否是所属的自己的猪场
	}

    //猪场首页
    public function index($id){
        $user = self::$user_arr;
        $zc = db("Cwh")->where(array("id"=>$id))->find();
        $this->assign("zc",$zc);
        if($zc['category'] == 1){
            return $this->fetch("production");
        }elseif($zc['category'] == 2){
            return $this->fetch("breeding");
        }
    }

}
