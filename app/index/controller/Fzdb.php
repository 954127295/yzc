<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;

class Fzdb extends Common
{
    // 分组对比
    public function index($id=''){
        $dyfz = db('dyfz')->where('cid',session('cid'))->field('id,fzname')->select();
        $dyinfo = db('unit')->where('dyfzid',$id)->select();
        $arr = array();
        foreach ($dyinfo as $k => &$v) {
            $arr = $dyinfo;
            $hardware = db('hardware')->where('SID',$v['controller'])->order('id desc')->find();
            $arr[$k]['HU'] = $hardware['HU'];
            $arr[$k]['T1'] = $hardware['T1'];
            $arr[$k]['T2'] = $hardware['T2'];
            $arr[$k]['T3'] = $hardware['T3'];

            if($v['dytype'] == 1 || $v['dytype'] == 2){//查询保育单元统计
                $data = db('pigpen')->where(array("dyid"=>$v['id']))->select();
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
                $arr[$k]['current_date_year'] = $num['current_date_year'];
                $arr[$k]['cunlan'] = $num['cunlan'];
            }
            if($v['dytype'] == 3){
                $data = array();
                $data['in_num'] = db("pigpen")->where(array("dyid"=>$v['id']))->count();//初始数量
                $data['die_num'] = db("penlog")->where(array("dyid"=>$v['id'],"out_reason"=>"死亡"))->count();//死亡头数
                $data['cunlan'] = $data['in_num'] - $data['die_num'];//当前总数
                $pens = db('pigpen')->where($where)->field("id")->select();
                $data['current_date_year'] = 0;
                foreach($pens as $d){
                    $penlogs = db("penlog")->where(array("pen_id"=>$d['id']))->field("tc")->order("id desc")->find();
                    $data['current_date_year'] += $penlogs['tc'];//当前日龄
                }
                $arr[$k]['current_date_year'] = $data['current_date_year'];
                $arr[$k]['cunlan'] = $data['cunlan'];
            }
            if($v['dytype'] == 4){
                $data = db('pigpen')->where(array("dyid"=>$v['id']))->field("id")->select();
                $num = array();
                $num['in_num'] = db("pigpen")->where(array("dyid"=>$v['id']))->count();//转入头数
                $bycount = db("bylog")->where(array("dyid"=>$v['id'],"status"=>"母猪死亡"))->count();
                $num['mother_cunlan'] = $num['in_num'] - $bycount;//母猪存栏量
                $num['mother_die'] = $bycount;//母猪死亡量
                $bycount_c = db("bylog")->where(array("dyid"=>$v['id'],"status"=>"母猪转出"))->count();
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
                $arr[$k]['current_date_year'] = $result['current_date_year'];
                $arr[$k]['cunlan'] = $data['result'];
            }

        }
        $this->assign([
            'dyinfo' => $dyinfo,
            'dyfz' => $dyfz,
            'id' => $id,
        ]);
        return view();
    }


}
