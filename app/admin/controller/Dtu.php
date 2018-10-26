<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
class Dtu extends Common
{
    // dtu列表
    public function lst(){
        $data = db('dtu')->paginate(10);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    //dtu添加
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            // 存入场id
            // $data['cid'] = session('cid');
            $data['addtime'] = time();
            $ins = db('dtu')->insert($data);
            if($ins){
                $this->success('添加DTU成功','lst','','1');
            }else{
                $this->error('添加DTC失败');
            }
        }
    }

    // 修改dtu
    public function edit($id){
        if(request()->isPost()){
            $data = input('post.');
            $save = db('dtu')->where('id',$id)->update($data);
            if($save){
                $this->success('修改DTU成功','lst','','1');
            }else{
                $this->error('修改dtu失败');
            }
        }
        $date = db('dtu')->where('id',$id)->find();
        $this->assign([
            'date' => $date,
        ]);
        return view();
    }

    // 删除DTU
    public function del($id){
        $del = db('dtu')->where('id',$id)->delete();
        if($del){
            $this->success('删除成功','lst','','1');
        }else{
            $thos->error('删除失败');
        }
    }
}
