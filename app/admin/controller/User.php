<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class User extends Common{
	public function __construct(){
		parent::__construct();
	}

    // 单元列表
    public function lst(){
        $data = db('User')->paginate(10);
        $chang = db("Cwh")->field("id,xmname")->select();
        $this->assign("chang",$chang);
        $this->assign([
            'data' => $data,
        ]);
        return view();
    }

    //用户添加
    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $data['key'] = rand(100,999);
            $data['password'] = md5(md5($data['password']).$data['key']);
            $res = db('User')->insert($data);
            if($res){
                $this->success('用户添加成功');
            }else{
                $this->error('用户添加失败');
            }
        }else{
            $chang = db("Cwh")->field("id,xmname")->select();
            $this->assign("chang",$chang);
            return $this->fetch();
        }
    }

    //用户修改
    public function edit(){
        $id = input("post.id");
        $column = input("post.column");
        $value = input("post.value");
        if($column == "password"){
            $user = db("User")->where(array("id"=>$id))->field("key")->find();
            $val = md5(md5($value).$user['key']);
        }else{
            $val = $value;
        }
        $data[$column] = $val;
        $where['id'] = $id;
        db("User")->where($where)->update($data);
        echo true;
    }

}
