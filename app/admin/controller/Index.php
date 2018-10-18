<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
class Index extends Common
{
    /**
     * 首页
     */
    public function index(){
        // echo 1;die;
        return $this->fetch();
    }
}
