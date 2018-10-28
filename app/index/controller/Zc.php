<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class Zc extends Common{
	public function __construct(){
		parent::__construct();
        //判断是否是所属的自己的猪场
	}

    //猪场首页
    public function index($id){
        $user = self::$user_arr;
        $zc = db("Cwh")->where(array("id"=>$id))->find();
        if(empty($zc)){
            $this->error("不存在");
        }
        Session::set('zc_id',$zc['id']);
        $this->assign("zc",$zc);
        $res = file_get_contents("http://api.help.bj.cn/apis/weather6d/?id=".$zc['city']);
        $result = json_decode($res,true);
        // dump($result);die;
        $weather = $result['data']['forecast'];
        $new_weather = array();
        foreach($weather as $w){
            list($day,$week) = explode(" ",$w['date']);
            $w['day'] = $day;
            $w['week'] = $week;
            $new_weather[] = $w;
        }
        // dump($cinfo);die;
        $this->assign("weather",$new_weather);
        if($zc['category'] == 1){
            $byinfo = db('unit')->where('cid',session('cid'))->where('dytype',1)->select();
            $yfinfo = db('unit')->where('cid',session('cid'))->where('dytype',2)->select();
            // dump($byinfo);die;
            $this->assign([
                'byinfo' => $byinfo,
                'yfinfo' => $yfinfo
            ]);
            return $this->fetch("production");
        }elseif($zc['category'] == 2){
            $hyinfo = db('unit')->where('cid',session('cid'))->where('dytype',3)->select();
            $fminfo = db('unit')->where('cid',session('cid'))->where('dytype',4)->select();
            $this->assign([
                'hyinfo' => $hyinfo,
                'fminfo' => $fminfo
            ]);
            return $this->fetch("breeding");
        }
    }
}
