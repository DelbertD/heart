<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/6 14:55 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Db;
use think\Request;

class Ask extends Base
{
    protected $url;
    protected $type = 3;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign([
            'url'   =>  $this->url
        ]);
    }

    public function lists()
    {
        $db = db('ask')
            ->order('sort,id');
        $askInfo = parent::_page($db,6);
        $this->assign([
            'askInfo' => $askInfo
        ]);
        return $this->fetch();
    }

    public function add()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $data['addtime'] = time();
            if(isset($data['file']))
            {
                unset($data['file']);
            }
            $data['uid'] = session('id');

            $r_data['uid']  = $data['uid'];
            $r_data['type'] = $this->type;

            //事务执行添加功能
            Db::startTrans();
            try{
                $id = Db::name('ask')->insertGetId($data);
                $r_data['rid'] = $id;
                $r_data['addtime'] = time();
                //记录添加记录
                Db::name('record')->insert($r_data);
                // 提交事务
                Db::commit();
                $this->success('添加问答成功！','heart/Ask/lists');
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error('添加问答失败！');
            }
        }

        return $this->fetch();
    }

    public function edit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file'])){unset($data['file']);}
            $res = db('ask')->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改问答成功！','heart/Ask/lists');
            }else{
                $this->error('修改问答失败！');
            }

        }
        $ask = db('ask')->where('id',$id)
            ->find();
        $this->assign([
            'ask' => $ask
        ]);
        return $this->fetch();
    }

    public function del($id = 0)
    {
        $res = db('ask')
            ->where('id',$id)
            ->limit(1)
            ->delete();
        if($res)
        {
            $this->success('删除问答成功！','heart/Ask/lists');
        }else{
            $this->error('删除问答失败！');
        }
    }

    /**
     * 异步修改排序
     */
    public function sort($id,$sort)
    {
        $res = db('ask')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Ask/lists');
        }else{
            $this->error('没有被修改！');
        }
    }
}