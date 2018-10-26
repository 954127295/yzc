<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
class Cwh extends Common
{
    public function index(){
        return view();
    }

    // 场信息添加
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $data['time'] = time();
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
            $edit = db('cwh')->update($_edit);
            if($edit){
                $this->success('修改场信息成功','Index/index');
            }else{
                $this->error('修改场信息失败');
            }
        }
        $data = db('cwh')->where('id',$id)->find();
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
