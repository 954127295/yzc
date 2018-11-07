<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;
class Drugs extends Common{
    //首页场列表
    public function index(){
        if(Request()->isPost()){
            $date = input('post.');
            $ins = db('drugs')->insert($date);
            if($ins){
                $this->success('添加成功','','',1);
            }else{
                $this->error('添加失败');
            }
        }
        $data = db('drugs')->paginate(10);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }
    public function del($id){
        $del = db('drugs')->where('id',$id)->delete();
        if($del){
            $this->success('删除成功','index','',1);
        }else{
            $this->error('删除失败');
        }
        return view();
    }

    public function edit($id){
        if(Request()->isPost()){
            $date = input('post.');
            $save = db('drugs')->update($date);
            if($save){
                $this->success('修改成功','index','',1);
            }else{
                $this->error('修改失败');
            }
        }
        $data = db('drugs')->where('id',$id)->find();
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }
}
