<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
class Index extends Common{
	public function __construct(){
		parent::__construct();
	}

	//首页场列表
    public function index(){
        $data = db('cwh')->paginate(1);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    public function ceshi(){
    	echo "这是测试";
    }

    public function shiyu(){
    	echo "shiyu";
    }
}
