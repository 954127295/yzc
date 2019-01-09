<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
use \think\Db;
use \think\Session;
class Pic extends Common
{
    // 批次
    public function pc(){
        if(request()->isPost()){
            // dump(input('post.'));die;
            $data = input('post.');
            $yif = db('pic')->where('dyid',$data['dyid'])->find();
            if($yif){
                $edit = db('pic')->where('dyid',$data['dyid'])->update($data);
                if($edit){
                    $this->success('更新批次成功');
                }else{
                    $this->error('更新批次失败');
                }
            }else{
                $ins = db('pic')->insert($data);
                if($ins){
                    $this->success('更新批次成功');
                }else{
                    $this->error('更新批次失败');
                }
            }
        }
    }
}
