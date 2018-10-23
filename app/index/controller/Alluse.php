<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;

class Alluse extends Controller{
    public function login(){
        if($_POST){
            $request = Request::instance();
            $username = $request->post('username');
            $password = $request->post('password');
            $where['username'] = $username;
            $user = db("User")->where($where)->find();
            if(empty($user)){
                $this->error("用户不存在");
            }else{
                $key = $user['key'];
                $new_password = md5(md5($password).$key);
                if($new_password == $user['password']){
                    $save_user['uid'] = $user['id'];
                    $save_user['permission'] = $user['permission'];
                    Session::set("user",$save_user);
                    $this->redirect("Index/index");
                }else{
                    $this->error("密码错误");
                }
            }
        }else{
            return $this->fetch();
        }
    }
    public function error_show(){
        echo "木有权限";
    }


}
