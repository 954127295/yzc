<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
class Index extends Common{
	public function __construct(){
		parent::__construct();
	}

	//首页
    public function index(){

        $this->display();
    }

    public function ceshi(){
    	$this->display();
    }

    public function shiyu(){
    	echo "shiyu";
    }
}
