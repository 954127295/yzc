<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
class Dywh extends Common
{
    // 单元分组列表
    public function lst(){
        $data = db('dyfz')->where('cid',session('cid'))->paginate(10);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }
    // 单元分组添加
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $data['cid'] = session('cid');
            $data['addtime'] = date('Y-m-d');
            $ins = db('dyfz')->insert($data);
            if($ins){
                $this->success('添加单元分组成功','lst','','1');
            }else{
                $this->error('添加单元分组失败');
            }
        }
        return view();
    }
    // 单元分组修改
    public function edit($id){
        if(request()->isPost()){
            $date = input('post.');
            $ins = db('dyfz')->update($date);
            if($ins){
                $this->success('修改单元分组成功','lst','','1');
            }else{
                $this->error('修改单元分组失败');
            }
        }
        $data = db('dyfz')->where('id',$id)->find();
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    // 单元分组删除
    public function del($id){
        $del = db('dyfz')->delete($id);
        if($del){
            $this->success('删除单元分组成功','lst','','1');
        }else{
            $this->error('删除单元分组失败');
        }
    }


}
