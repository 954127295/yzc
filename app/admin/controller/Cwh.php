<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
class Cwh extends Common
{
    public function index(){
        return view();
    }

    //城市检查
    private function check_city($city){
        $sql = "select CityCode from pig_city_number where instr('".$city."',ReadmeName)>0";
        $res = Db::query($sql);
        return $res[0]['CityCode'];
    }

    // 场信息添加
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $data['time'] = time();
            //检查城市
            $data['city'] = $this->check_city($data['city']);
            if(empty($data['city'])){
                $this->error("请输入正确城市");
            }
            $date = db('cwh')->insert($data);
            if($date){
                $this->success('添加场信息成功');
            }else{
                $this->error('添加场信息失败，请重新添加');
            }
        }
        return view();
    }

    // 场信息修改
    public function edit($id){
        if(request()->isPost()){
            $_edit = input('post.');
            //检查城市
            $_edit['city'] = $this->check_city($_edit['city']);
            if(empty($_edit['city'])){
                $this->error("请输入正确城市");
            }
            $edit = db('cwh')->update($_edit);
            if($edit){
                $this->success('修改场信息成功','Index/index');
            }else{
                $this->error('修改场信息失败');
            }
        }
        $data = db('Cwh')->where('id',$id)->find();
        $city = db("CityNumber")->where(array("CityCode"=>$data['city']))->field("ReadmeName")->find();
        $data['cityname'] = $city['ReadmeName'];
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    // 场删除
    public function del($id){
        $del = db('cwh')->delete($id);
        if($del){
            $this->success('删除场信息成功','Index/index');
        }else{
            $this->error('删除场信息失败');
        }
    }

}
