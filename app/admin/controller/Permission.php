<?php
namespace app\admin\controller;
use \think\Controller;
use \think\Request;
use think\Session;

class Permission extends Common{
	public function __construct(){
		parent::__construct();
	}

    //权限查看
    public function show(){
        $list = db("Permission")->order("show_order")->select();
        $new_list = array();
        foreach($list as $li){
            $per = explode(",",$li['per']);
            foreach($per as $p){
                switch($p){
                    case 1:
                        $li['permission'][] = "集团总监";
                    break;
                    case 2:
                        $li['permission'][] = "区域总监";
                    break;
                    case 3:
                        $li['permission'][] = "子公司总监";
                    break;
                    case 4:
                        $li['permission'][] = "场长";
                    break;
                    case 5:
                        $li['permission'][] = "段长";
                    break;
                    case 6:
                        $li['permission'][] = "饲养员";
                    break;
                }
            }
            $new_list[] = $li;
        }
        $this->assign("data",$new_list);
        return $this->fetch();
    }

    //权限修改
    public function edit(){
        if(request()->isPost()){
            $data = input("post.");
            $where['id'] = $data['hid'];
            $per = implode(",",$data['per']);
            $datas['per'] = $per;
            db("Permission")->where($where)->update($datas);
            $this->success("修改成功");
        }else{
            $id = input('id');
            $where['id'] = $id;
            $permission = db("Permission")->where($where)->field("per,name")->find();
            $per_arr = explode(",",$permission['per']);
            $this->assign("pers",$per_arr);
            $this->assign("pername",$permission['name']);
            $this->assign("id",$id);
            return $this->fetch();
        }
    }

}
