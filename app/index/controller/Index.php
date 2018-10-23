<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
class Index extends Common{
	public function __construct(){
		parent::__construct();
	}

	//首页
    public function index(){
        return $this->fetch();
    }

    public function ceshi(){
    	echo "这是测试";
    }

    public function shiyu(){
    	echo "shiyu";
    }
}
