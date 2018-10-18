<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
class Cwh extends Common
{
    public function index(){
        return view();
    }


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
    public function lst(){
        $data = db('cwh')->paginate(1);
        // dump($data);die;
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    public function edit(){
        return view();
    }
}
