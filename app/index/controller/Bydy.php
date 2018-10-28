<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Bydy extends Common
{
    // 保育单元信息
    public function index(){
        $bydyinfo = db('pigpen')->where('dyid',session('dyid'))->select();
        // dump($bydyinfo);die;
        $this->assign('info',$bydyinfo);
        return view();
    }

}
