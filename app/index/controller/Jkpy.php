<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
// 动物健康哺育单元
class Jkpy extends Common
{
    // 动物哺育界面
    public function index($typeid='1'){
        // dump($typeid);
        // 药品
        $myypinfo = db('drugs')->field('id,yname')->select();
        // 免疫数据显示
        $data = db('dwmy')
        ->alias('a')
        ->field('a.*,b.yname')
        ->join('drugs b','a.type = b.id')
        ->where('a.dyid',session('dyid'))
        ->where('a.typeid',$typeid)
        ->select();
        // dump($data);die;
        // 耳标号
        $ebh = db('pigpen')->where('dyid',session('dyid'))->field('jnumber')->select();
        $zl = db('dwzl')->where('dyid',session('dyid'))->where('typeid',$typeid)->select();
        $zlname = db('unit')->where('id',session('dyid'))->field('dyname')->find();
        $arr = array();
        foreach ($zl as $k => $v) {
            $arr[] = $v['bz'];
        }
        foreach (array_count_values($arr) as $key => $value) {
            $_arr[$key] = (string)$value;
        }
        $zlzz = db('zlzz')->select();
        $yylx = db('yylx')->select();
        $time = date('Y-m-d');
        // dump($zl);die;
        $this->assign([
            'time' => $time,//时间
            'bt' => $_arr,//饼图
            'typeid' => $typeid,
            'zlname' => $zlname['dyname'],//饼图
            'info' => $myypinfo,
            'data' => $data,//免疫數據
            'ebh' => $ebh,//耳標號
            'zl' => $zl,//治療結果
            'zlzz' => $zlzz,//治疗症状
            'yylx' => $yylx,//用药类型
        ]);
        return view();
    }

    // 添加动物免疫
     public function myadd(){
        if(Request()->isPost()){
            $_data = input('post.');
            // dump($_data);die;
            if($_data['typeid']==1){
                $dynum = db('dwmy')->where('dyid',session('dyid'))->where('typeid',1)->select();
                if(count($dynum)>2){
                    $this->error('最多免疫3次');
                }
            }else{
                $dynum = db('dwmy')->where('dyid',session('dyid'))->where('typeid',2)->select();
                if(count($dynum)>2){
                    $this->error('最多免疫3次');
                }
            }

            if(!$_data['mytime']){
                $_data['mytime'] =  date('Y-m-d');
            }
            $data = db('drugs')->where('id',$_data['type'])->find();
            $dy = db('pigpen')->where('dyid',session('dyid'))->select();
            $date = array();
            $date['mytype'] = $data['id'];
            $date['mytime'] = $_data['mytime'];
            $date['type'] = $data['id'];
            $date['typeid'] = $_data['typeid'];
            $date['time'] = time();
            $date['eh'] = $_data['eh'];
            $date['yyl'] = $data['zsml'];
            $date['yyzl'] = $data['zsml']*count($dy);
            $date['dyid'] = session('dyid');
            // dump($date);die;
            $ins = db('dwmy')->insert($date);
            if($ins){
                $this->success('添加免疫数据成功',url('index',array('typeid'=>$_data['typeid'])),'',1);
            }else{
                $this->error('添加免疫数据失败','index','',1);
            }
        }
    }
    // 添加动物治疗
    public function zladd(){
        if(Request()->isPost()){
            $_data = input('post.');
            $_data['dyid'] = session('dyid');
            $_data['time'] = time();
            // dump($_data);die;
            $ins = db('dwzl')->insert($_data);
            if($ins){
                $this->success('添加治疗数据成功','index','',1);
            }else{
                $this->error('添加治疗数据失败','index','',1);
            }
        }
    }

}
