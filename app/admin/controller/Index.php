<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;
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

}
