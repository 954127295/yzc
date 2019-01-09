<?php
namespace app\index\controller;
use \think\Controller;
use \think\Request;
class Dylb extends Common
{
    // 单元列表
    public function lst(){
        // dump(session('cid'));die;

        $data = db('unit')
        ->field('a.*,b.fzname,b.id as dyid,c.dtuname,c.id as dtuid')
        ->alias('a')
        ->join('dyfz b','a.dyfzid=b.id')
        ->join('dtu c','a.dtuid=c.id')
        ->where('a.cid',session('cid'))
        ->paginate(10);
        $_data = db('unit')->where('cid',session('cid'))->select();

        // dump($_data);die;
        $this->assign([
            'data' => $data,
            'data1' => $_data,
            'data2' => $__data,
        ]);
        return view();
    }

    // 添加单元
    public function add(){
        if(Request()->isPost()){
            $data = input('post.');
            // dump($data);die;
            $data['monitor'] = json_encode($data['monitor'],JSON_UNESCAPED_SLASHES);//后期使用\r\n分隔地址
            $data['addtime'] = time();
            if(!$data['dyfzid']){
                $this->error('请选择单元分组');
            }
            if(!$data['dtuid']){
                $this->error('请选择接入DTU');
            }
            //添加场
            $data['cid'] = session('cid');
            $add = db('unit')->insert($data);
            if($add){
                $this->success('添加单元成功','lst','','1');
            }else{
                $this->error('添加单元失败');
            }
        }
        $dyfz = db('dyfz')->field('id,fzname')->where('cid',session('cid'))->select();
        $dtu = db('dtu')->field('id,dtuname')->where('cid',session('cid'))->select();
        $ctype = db('cwh')->where('id',session('cid'))->field('category')->find();
        // dump($ctype['category']);die;
        // dump(session('cid'));die;
        $this->assign([
            'dyfz' => $dyfz,
            'dtu' => $dtu,
            'ctype' => $ctype['category'],
        ]);
        return view();
    }
    // 修改单元
    public function edit($id){
        if(Request()->isPost()){
            $_save = input('post.');
            $_save['monitor'] = json_encode($_save['monitor'],JSON_UNESCAPED_SLASHES);//后期使用\r\n分隔地址
            $save = db('unit')->where('id',$id)->update($_save);
            if($save){
                $this->success('修改单元成功','lst','','1');
            }else{
                $this->error('修改单元失败');
            }
        }
        $data = db('unit')
        ->field('a.*,b.fzname,b.id as dyid,c.dtuname,c.id as dtuid')
        ->alias('a')
        ->join('dyfz b','a.dyfzid=b.id')
        ->join('dtu c','a.dtuid=c.id')
        ->where('a.id',$id)
        ->find();
        $data['monitor'] = json_decode($data['monitor']);
        $dyfz = db('dyfz')->field('id,fzname')->where('cid',session('cid'))->select();
        $dtu = db('dtu')->field('id,dtuname')->where('cid',session('cid'))->select();
        $ctype = db('cwh')->where('id',session('cid'))->field('category')->find();
        $this->assign([
            'data' => $data,
            'dyfz' => $dyfz,
            'dtu' => $dtu,
            'ctype' => $ctype['category'],
        ]);
        return view();
    }

    // 删除单元
    public function del($id){
        $del = db('unit')->where('id',$id)->delete();
        if($del){
            $this->success('删除单元成功','lst','','1');
        }else{
            $this->error('删除单元失败');
        }
    }

}
