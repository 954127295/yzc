<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
// 动物健康保育单元
class Jkyf extends Common
{
    // 动物免疫界面
    public function index(){
        // 药品
        $myypinfo = db('drugs')->field('id,yname')->select();
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
        $zlname = db('unit')->where('id',session('dyid'))->field('dyname')->find();
        // dump($zl);
        $arr = array();
        foreach ($zl as $k => $v) {
            $arr[] = $v['bz'];
        }
        foreach (array_count_values($arr) as $key => $value) {
            $_arr[$key] = (string)$value;
        }
        // $a = array_count_values($arr);
        // dump($_arr);die;
        $zlzz = db('zlzz')->select();
        $yylx = db('yylx')->select();
        $time = date('Y-m-d');
        // dump($time);die;
        // dump($zlname);die;
        $this->assign([
            'time' => $time,//时间
            'bt' => $_arr,//饼图
            'zlname' => $zlname['dyname'],
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
            $ifnum = db('dwmy')->where('dyid',session('dyid'))->select();
            if(count($ifnum)>2){
                $this->error('最多免疫3次');
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

    // 删除数据
    public function del($id){
        $del = db('dwzl')->delete($id);
        if($del){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

}
