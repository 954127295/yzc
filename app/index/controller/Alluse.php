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
                    Session::set("username",$user['name']);
                    $save_user['uid'] = $user['id'];
                    $save_user['permission'] = $user['permission'];
                    Session::set("user",$save_user);
                    if(in_array($user['permission'],array(1,2,3))){
                        $this->redirect("Index/choose");
                    }elseif(in_array($user['permission'],array(4,5,6))){
                        $zc_id = $user['cid'];//此处查询数据库猪场与用户关联
                        Session::set("cid",$zc_id);
                        $this->redirect("Zc/index",array("id"=>$zc_id));
                    }else{
                        $this->error("没有相关权限进入");
                    }
                }else{
                    $this->error("密码错误");
                }
            }
        }else{
            return $this->fetch();
        }
    }

    //退出登录
    public function logout(){
        Session::delete('user');
        $this->redirect("Alluse/login");
    }

}
