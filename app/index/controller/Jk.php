<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Jk extends Common
{
    // 单元监控
    public function index($id){
        // 单元id
        Session::set('dyid',$id);
        $dyinfo = db('unit')->where('id',$id)->find();
        $this->assign([
            'dyinfo' => $dyinfo,
        ]);
        // dump($dyinfo);
        return view();
    }

}
