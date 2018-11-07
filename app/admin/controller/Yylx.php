<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;
class Yylx extends Common{
    //用药类型
    public function index(){
        if(Request()->isPost()){
            $date = input('post.');
            $ins = db('yylx')->insert($date);
            if($ins){
                $this->success('添加成功','','',1);
            }else{
                $this->error('添加失败');
            }
        }
        $data = db('yylx')->paginate(10);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }
    public function del($id){
        $del = db('yylx')->where('id',$id)->delete();
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
            $save = db('yylx')->update($date);
            if($save){
                $this->success('修改成功','index','',1);
            }else{
                $this->error('修改失败');
            }
        }
        $data = db('yylx')->where('id',$id)->find();
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }
}
