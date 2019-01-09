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
        $hwt = $this->get_hardwaret();
        $this->assign("hwt",$hwt);
        $this->assign("hw",$res);
        $this->assign("num",$this->get_dylist());
        return view();
    }
    private function get_hardwaret(){
        $redis = $this->get_redis();
        $result = $redis->lrange("yzct",0,0);
        $res = db('hardwaret')->order("id desc")->find();
        return $res;
    }
    //当前动物数、初始数量、日龄、死亡、免疫、治疗
    //取单元数据
    private function get_dylist(){
        $dyid = Session::get("dyid");
        $where['id'] = $dyid;
        $res = db("unit")->where($where)->field("dytype")->find();
        $dytype = $res['dytype'];
        switch($dytype){
            case 1:
                $result = $this->get_bao_num();
            break;
            case 2:
                $result = $this->get_bao_num();
            break;
            case 3:
                $result = $this->get_hy_num();
            break;
            case 4:
                $result = $this->get_py_num();
            break;
        }
        return $result;
    }
    //哺育数据
    private function get_py_num(){
        $dyid = Session::get("dyid");
        $where['dyid'] = $dyid;
        $data = db('pigpen')->where($where)->field("id")->select();
        $num = array();
        $num['in_num'] = db("pigpen")->where(array("dyid"=>$dyid))->count();//转入头数
        $bycount = db("bylog")->where(array("dyid"=>$dyid,"status"=>"母猪死亡"))->count();
        $num['mother_cunlan'] = $num['in_num'] - $bycount;//母猪存栏量
        $num['mother_die'] = $bycount;//母猪死亡量
        $bycount_c = db("bylog")->where(array("dyid"=>$dyid,"status"=>"母猪转出"))->count();
        $mother_cha = $num['in_num'] - $bycount - $bycount_c;
        $num['mother_cha'] = $mother_cha != 0?"<a style='color:red;'>".$mother_cha."</a>":0;//母猪差异
        foreach($data as $d){
            $res = db("bylog")->where(array("pen_id"=>$d['id']))->field("")->order("id desc")->find();
            $num['children_die_num'] += $res['children_die_num'];//仔猪死亡量
            $num['health_num'] += $res['health_num'];//健仔
            $num['die_num'] += $res['die_num'];//死胎
            $num['weak_num'] += $res['weak_num'];//弱仔
            $num['deformity_num'] += $res['deformity_num'];//畸形
            $num['children_out_num'] += $res['children_out_num'];
            $num['tc'] += $res['tc'];//胎次

        }
        $num['children_all_num'] = $res['health_num'] - $res['children_die_num'];//仔猪存栏量
        @$num['children_ok_rate'] = ($num['health_num']-$num['die_num'])/$num['health_num'];//存活率
        $children_cha = $num['health_num'] - $num['children_out_num'];
        $num['children_cha'] = $children_cha != 0?"<a style='color:red;'>".$children_cha."</a>":0;//仔猪差异
        $result = array();
        $result['in_num'] = "母猪(".$num['in_num'].")仔猪(".$num['health_num'].")";//初始数量
        $result['die_num'] = "母猪(".$num['mother_die'].")仔猪(".$num['children_die_num'].")";//死亡头数
        $result['cunlan'] = "母猪(".$num['mother_cunlan'].")仔猪(".$num['children_all_num'].")";//当前总数
        $result['current_date_year'] = $num['tc'];//当前日龄
        return $result;
    }
    //怀孕数据
    private function get_hy_num(){
        $dyid = Session::get("dyid");
        $data = array();
        $data['in_num'] = db("pigpen")->where(array("dyid"=>$dyid))->count();//初始数量
        $data['die_num'] = db("penlog")->where(array("dyid"=>$dyid,"out_reason"=>"死亡"))->count();//死亡头数
        $data['cunlan'] = $data['in_num'] - $data['die_num'];//当前总数
        $pens = db('pigpen')->where($where)->field("id")->select();
        $data['current_date_year'] = 0;
        foreach($pens as $d){
            $penlogs = db("penlog")->where(array("pen_id"=>$d['id']))->field("tc")->order("id desc")->find();
            $data['current_date_year'] += $penlogs['tc'];//当前日龄
        }
        return $data;
    }
    //保育数据
    private function get_bao_num(){
        $dyid = Session::get("dyid");
        $where['dyid'] = $dyid;
        $data = db('pigpen')->where($where)->field("id")->select();
        $num = array();
        $time = time();
        $in_date = 0;
        foreach($data as $d){
            $res = db("baolog")->where(array("pen_id"=>$d['id']))->field("in_num,die_num,current_weight,in_date_year,out_num,put_time,in_heavy")->order("id desc")->find();
            $num['in_num'] += $res['in_num'];//初始数量
            $num['cunlan'] += $res['in_num'] - $res['die_num'];//当前总数
            $num['die_num'] += $res['die_num'];//死亡量
            $in_date += ($time - $res['put_time'])/86400;
        }
        $num['current_date_year'] = ceil($in_date);//当前日龄
        return $num;
    }

}
