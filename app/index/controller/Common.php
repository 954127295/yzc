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
        $user = Session::get('user');
    	if(empty($user)){
    		$this->redirect("Alluse/login");
    	}else{
            self::$user_arr = $user;
        }
    }
}
