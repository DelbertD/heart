<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/7 15:19 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class Say extends Base
{
    protected $url;
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

        $db = db('pj')
            ->order('sort,id');
        $sayInfo = parent::_page($db,6);
        $this->assign([
            'sayInfo' => $sayInfo
        ]);
        return $this->fetch();
    }


    public function add()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file']))
            {
                unset($data['file']);
            }
            $data['uid'] = session('id');
            $res = db('pj')
                ->insert($data);
            if($res)
            {
                $this->success('添加评价成功！','heart/Say/lists');
            }else{
                $this->error('添加评价失败！');
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
            $res = db('pj')->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改评价成功！','heart/Say/lists');
            }else{
                $this->error('修改评价失败！');
            }

        }
        $say = db('pj')->where('id',$id)
            ->find();
        $this->assign([
            'say' => $say
        ]);
        return $this->fetch();
    }

    public function del($id = 0)
    {
        $res = db('pj')
            ->where('id',$id)
            ->limit(1)
            ->delete();
        if($res)
        {
            $this->success('删除评价成功！','heart/Say/lists');
        }else{
            $this->error('删除评价失败！');
        }
    }

    /**
     * 异步修改排序
     */
    public function sort($id,$sort)
    {
        $res = db('pj')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Say/lists');
        }else{
            $this->error('没有被修改！');
        }
    }
}