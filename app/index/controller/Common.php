<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;

class Common extends Controller{
    protected static $user_arr = array();
    public function __construct(){
        parent::__construct();
        $request = Request::instance();
        $c = $request->controller();
    	$a = $request->action();
        $this->assign("c",$c);
        $this->assign("a",$a);
        $dyinfo = db('unit')->where('id',session('dyid'))->field('dytype')->find();
        $this->assign("category",$dyinfo['dytype']);
        $user = Session::get('user');
        // echo 1;
    	if(empty($user)){
    		$this->redirect("Alluse/login");
    	}else{
            $cid = Session::get('cid');
            if(empty($cid) && !in_array($user['permission'],array(1,2,3))){
                $this->redirect("Alluse/login");
            }
            self::$user_arr = $user;
        }
    }
}
