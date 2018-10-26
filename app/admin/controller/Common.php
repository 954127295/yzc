<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Session;

class Common extends Controller{
    public function _initialize(){
        $request = Request::instance();
        $c = $request->controller();
    	$a = $request->action();
        $user = Session::get('user');
    	if(empty($user)){
    		$this->redirect("Alluse/login");
    	}
    	$permission = $user['permission'];
    	$where['controller'] = $c;
    	$where['function'] = $a;
    	$pers = db("Permission")->where($where)->field("per,name")->find();
    	$pre_arr = explode(",",$pers['per']);
    	if(!in_array($permission,$pre_arr)){
    		$this->error("非法操作");
    	}else{
            $this->assign("c",$c);
            $this->assign("a",$a);
            $this->assign("per",$pers['name']);
        }
    }
}
