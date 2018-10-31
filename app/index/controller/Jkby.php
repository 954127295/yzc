<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
// 动物健康保育单元
class Jkby extends Common
{
    // 动物免疫界面
    public function index(){
        // 药品
        $myypinfo = db('drugs')->where('typenum',4)->field('id,yname')->select();
        // 免疫数据显示
        $data = db('dwmy')
        ->alias('a')
        ->field('a.*,b.yname')
        ->join('drugs b','a.type = b.id')
        ->where('a.dyid',session('dyid'))
        ->select();
        // 耳标号
        $ebh = db('pigpen')->where('dyid',session('dyid'))->field('jnumber')->select();
        $zl = db('dwzl')->where('dyid',session('dyid'))->select();

        // dump($zl);die;
        $this->assign([
            'info' => $myypinfo,
            'data' => $data,//免疫數據
            'ebh' => $ebh,//耳標號
            'zl' => $zl,//治療結果
        ]);
        return view();
    }
    // 添加动物免疫
    public function myadd(){
        if(Request()->isPost()){
            $_data = input('post.');
            $data = db('drugs')->where('id',$_data['type'])->find();
            $dy = db('pigpen')->where('dyid',session('dyid'))->select();
            $date = array();
            $date['mytype'] = $data['id'];
            $date['type'] = $data['id'];
            $date['time'] = time();
            $date['yyl'] = $data['zsml'];
            $date['yyzl'] = $data['zsml']*count($dy);
            $date['dyid'] = session('dyid');
            $ins = db('dwmy')->insert($date);
            if($ins){
                $this->success('添加免疫数据成功','index','',1);
            }else{
                $this->error('添加免疫数据失败','index','',1);
            }
        }
    }
    // 添加动物治疗
    public function zladd(){
        if(Request()->isPost()){
            $_data = input('post.');
            $zz = array('1'=>'大肠杆菌','2'=>'猪链球菌','3'=>'副猪嗜血杆菌','4'=>'支原体','5'=>'巴氏杆菌','6'=>'波氏杆菌','7'=>'沙门氏菌','8'=>'梭菌');
            $_data['bz'] = $zz[$_data['bz']];
            $_data['dyid'] = session('dyid');
            $_data['time'] = time();
            $ins = db('dwzl')->insert($_data);
            if($ins){
                $this->success('添加治疗数据成功','index','',1);
            }else{
                $this->error('添加治疗数据失败','index','',1);
            }
        }
    }

}
