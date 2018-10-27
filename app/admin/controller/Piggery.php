<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class Piggery extends Common{

    //首页场列表
    public function lst($dyid){
        $dyinfo = db('unit')->where('id',$dyid)->field('id,dyname,dytype')->find();
        $data = db('pigpen')->paginate(1);
        $this->assign([
            'dyinfo' => $dyinfo,
            'data' => $data,
        ]);
        return view();
        // if($dyinfo['dytype'] == 1 OR $dyinfo['dytype'] ==2){
        //     return $this->fetch('Piggery/sclst');//生产厂
        // }else{
        //     return $this->fetch('Piggery/fzlst');//繁殖场
        // }
    }

    // 添加猪圈/耳标号
    public function add(){
        if(Request()->isPost()){
            $data = input('post.');
            $data['addtime'] = time();
            $ins = db('pigpen')->insert($data);
            if($ins){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }
    }
    // 删除猪圈/耳标号
    public function del($id){
        $del = db('pigpen')->delete($id);
        if($del){
            $this->success('删除成功','','',1);
        }else{
            $this->error('添加失败');
        }
    }
    // 修改猪圈/耳标号
    public function edit($id){
        if(Request()->isPost()){
            $date = input('post.');
            $unitid = $date['unitid'];
            unset($date['unitid']);
            $save = db('pigpen')->update($date);
            if($save){
                $this->redirect('lst', ['dyid' => $unitid]);
            }else{
                $this->error('修改失败');
            }
        }
        $date = db('pigpen')
        ->alias('a')
        ->join('unit b','a.dyid=b.id')
        ->where('a.id',$id)
        ->field('a.*,b.dyname,b.dytype,b.id as unitid')
        ->find();
        $this->assign([
            'date' => $date,
        ]);
        return view();
    }




}
