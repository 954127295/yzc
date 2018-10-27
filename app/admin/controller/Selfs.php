<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use \think\Request;
use think\Session;

class Selfs extends Common{
	public function __construct(){
		parent::__construct();
	}

	//个人信息管理
    public function information(){
        $user = Session::get('user');
        if($_POST){
            $request = Request::instance();
            $info = $request->post();
            $res = db("User")->where(array("id"=>$user['uid']))->update($info['info']);
            if($res){
                $this->success("修改成功");
            }
        }else{
            $info = db("User")->where(array("id"=>$user['uid']))->find();
            $this->assign("info",$info);
            return $this->fetch();
        }
    }

    //密码修改
    public function password(){
        $user = Session::get('user');
        if($_POST){
            $request = Request::instance();
            $infos = $request->post();
            $info = $infos['info'];
            $check_user = db("User")->where(array("id"=>$user['uid']))->find();
            $new_password = md5(md5($info['oldpassword']).$check_user['key']);
            if($new_password != $check_user['password']){
                $this->error("修改失败，原密码错误");
            }else{
                $res = db("User")->where(array("id"=>$user['uid']))->update(array("password"=>md5(md5($info['newpassword']).$check_user['key'])));
                if($res){
                    $this->success("修改成功");
                }
            }
        }else{
            return $this->fetch();
        }
    }

}
