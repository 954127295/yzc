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
        Session::delete('dyid');
        session('dyid',$id);
        $user = self::$user_arr;
        $zc = db("Cwh")->where(array("id"=>$id))->find();
        // dump($zc);die;
        if(empty($zc)){
            $this->error("不存在");
        }
        Session::set('zc_id',$zc['id']);
        $this->assign("zc",$zc);
        // $res = file_get_contents("http://api.help.bj.cn/apis/weather6d/?id=".$zc['city']);
        // $result = json_decode($res,true);
        // // dump($result);die;
        // $weather = $result['data']['forecast'];
        // $new_weather = array();
        // foreach($weather as $w){
        //     list($day,$week) = explode(" ",$w['date']);
        //     $w['day'] = $day;
        //     $w['week'] = $week;
        //     $new_weather[] = $w;
        // }
        // // dump($cinfo);die;
        // $this->assign("weather",$new_weather);
        if($zc['category'] == 1){
            $byinfo = db('unit')->where('cid',session('cid'))->where('dytype',1)->select();
            $yfinfo = db('unit')->where('cid',session('cid'))->where('dytype',2)->select();
            // dump($byinfo);die;
            $this->assign([
                'byinfo' => $byinfo,
                'yfinfo' => $yfinfo
            ]);
            //获取育肥单元数据
            $num1 = $this->get_dy_num(1);
            $this->assign("num1",$num1);
            //获取育肥单元数据
            $num2 = $this->get_dy_num(2);
            $this->assign("num2",$num2);
            return $this->fetch("production");
        }elseif($zc['category'] == 2){
            $hyinfo = db('unit')->where('cid',session('cid'))->where('dytype',3)->select();
            $fminfo = db('unit')->where('cid',session('cid'))->where('dytype',4)->select();
            $this->assign([
                'hyinfo' => $hyinfo,
                'fminfo' => $fminfo
            ]);
            $num1 = $this->get_hy_num();//怀孕猪
            $this->assign("num1",$num1);
            $num2 = $this->get_py_num();//哺育猪
            $this->assign("num2",$num2);
            // $num2 = $this->get_py_num();//健仔
            // $this->assign("num2",$num2);
            return $this->fetch("breeding");
        }
    }

    private function get_hy_num(){
        $yfinfo = db('unit')->where('cid',session('cid'))->where('dytype',3)->select();
        $dyid_arr = array();
        foreach($yfinfo as $d){
            array_push($dyid_arr,$d['id']);
        }
        $dyid = implode(",",$dyid_arr);
        $where['dyid'] = array("in",$dyid);
        $data = array();
        $data['in_num'] = db("pigpen")->where(array("dyid"=>array("in",$dyid)))->count();//转入头数
        $data['die_num'] = db("penlog")->where(array("dyid"=>array("in",$dyid),"out_reason"=>"死亡"))->count();//死亡头数
        $data['cunlan'] = $data['in_num'] - $data['die_num'];//存栏量
        $data['out_num'] = db("penlog")->where(array("dyid"=>array("in",$dyid),"out_reason"=>"流产"))->count();//流产数量
        @$data['ok_lv'] = $this->rounds(($data['in_num']-$data['die_num'])/$data['in_num']);//成活率
        return $data;
    }

    private function get_py_num(){
        $yfinfo = db('unit')->where('cid',session('cid'))->where('dytype',3)->select();
        $dyid_arr = array();
        foreach($yfinfo as $d){
            array_push($dyid_arr,$d['id']);
        }
        $dyid = implode(",",$dyid_arr);
        $data = db('pigpen')->where(array("dyid"=>array("in",$dyid)))->field("id")->select();
        $num = array();
        $num['in_num'] = db("pigpen")->where(array("dyid"=>array("in",$dyid)))->count();//转入头数
        $bycount = db("bylog")->where(array("dyid"=>array("in",$dyid),"status"=>"母猪死亡"))->count();
        $num['mother_cunlan'] = $num['in_num'] - $bycount;//母猪存栏量
        $num['mother_die'] = $bycount;//母猪死亡量
        @$num['ok_lv'] = $this->rounds(($num['in_num']-$num['mother_die'])/$num['in_num']);//成活率
        $bycount_c = db("bylog")->where(array("dyid"=>array("in",$dyid),"status"=>"母猪转出"))->count();
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
        @$num['children_ok_rate'] = $this->rounds(($num['health_num']-$num['die_num'])/$num['health_num']);//存活率
        $children_cha = $num['health_num'] - $num['children_out_num'];
        $num['children_cha'] = $children_cha != 0?"<a style='color:red;'>".$children_cha."</a>":0;//仔猪差异
        return $num;
    }

    private function get_dy_num($c){
        $yfinfo = db('unit')->where('cid',session('cid'))->where('dytype',$c)->select();
        $dyid_arr = array();
        foreach($yfinfo as $d){
            array_push($dyid_arr,$d['id']);
        }
        $dyid = implode(",",$dyid_arr);
        $where['dyid'] = array("in",$dyid);
        $result = db('pigpen')->where($where)->select();
        $num = array();
        foreach($result as $d){
            $res = db("baolog")->where(array("pen_id"=>$d['id']))->field("in_num,die_num")->order("id desc")->find();
            $num['in_num'] += $res['in_num'];//转入头数
            $num['cunlan'] += $res['in_num'] - $res['die_num'];//存栏量
            $num['die_num'] += $res['die_num'];//死亡量
        }
        @$num['ok_lv'] = $this->rounds(($num['in_num']-$num['die_num'])/$num['in_num']);//成活率
        return $num;
    }

    private function rounds($num){
        $nums = sprintf("%.4f",$num);
        return $nums * 100;
    }

    public function add(){
        if(Request()->isPost()){
            $data = input('post.');
            if(!$data['dyfzid']){
                $this->error('请选择单元分组');
            }
            if(!$data['dtuid']){
                $this->error('请选择接入DTU');
            }
            $data['monitor'] = json_encode($data['monitor'],JSON_UNESCAPED_SLASHES);//后期使用\r\n分隔地址
            $data['addtime'] = time();
            //添加场
            $data['cid'] = session('cid');
            $add = db('unit')->insert($data);
            if($add){
                $this->success('添加单元成功');
            }else{
                $this->error('添加单元失败');
            }
        }
        $dyfz = db('dyfz')->field('id,fzname')->where('cid',session('cid'))->select();
        $dtu = db('dtu')->field('id,dtuname')->where('cid',session('cid'))->select();
        $ctype = db('cwh')->where('id',session('cid'))->field('category')->find();
        $this->assign([
            'dyfz' => $dyfz,
            'dtu' => $dtu,
            'ctype' => $ctype['category'],
        ]);
        return view();
    }
}
