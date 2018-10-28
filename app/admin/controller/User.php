<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class User extends Common{
	public function __construct(){
		parent::__construct();
	}

    public function lst(){
		if(request()->isPost()){
            $data = input('post.');
            print_r($data);
        }else{
        	return $this->fetch();
        }
    }

}
