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
        // dump($dyinfo['controller']);die;
        // $jkinfo = db('hardware')->where('id',$dyinfo['controller'])->order('id desc')->limit(1)->select();
        // dump($jkinfo);die;
        $info['dyname'] = '';
        $this->assign([
            'dyinfo' => $dyinfo,
            'info' => $info,
        ]);

        $redis = $this->get_redis();
        $result = $redis->lrange("yzc",0,0);

        if(empty($result)){
            $res = db('hardware')->order("id desc")->find();
        }else{
            $res = unserialize($result[0]);
            foreach($res as $k=>$r){
                if($r == "--"){
                    $res[$k] = '0';
                }
            }
        }
        $this->assign("hw",$res);

        return view();
    }

}
