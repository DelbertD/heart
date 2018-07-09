<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/1 11:36 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class About extends Base
{
    protected $url;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign([
            'url' => $this->url
        ]);
    }


    /**
     * 招聘列表
     * @return mixed
     */
    public function join()
    {
        $db = db('join')
            ->order('sort,id')
            ->field('id,name,abs,addtime,etime,money,is_show,sort');
        $joinList = parent::_page($db,6);
        $this->assign([
            'joinList' => $joinList,
        ]);
        return $this->fetch();
    }


    /**
     * 添加岗位信息
     * @return mixed
     */
    public function joinAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $data['addtime'] = time();
            if(isset($data['etime']))
            {
                $data['etime'] = strtotime($data['etime']);
            }

            $res = db('join')->insert($data);
            if($res)
            {
                $this->success('添加职位成功！','heart/About/join');
            }else{
                $this->error('添加职位失败！');
            }
        }
        return $this->fetch();
    }

    public function joinEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['etime']))
            {
                $data['etime'] = strtotime($data['etime']);
            }
            $res = db('join')->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改职位成功！','heart/About/join');
            }else{
                $this->error('修改职位失败！');
            }

        }
        $joinInfo = db('join')
            ->where('id',$id)
            ->limit(1)
            ->find();
        $this->assign([
            'joinInfo' => $joinInfo
        ]);
        return $this->fetch();
    }



    public function joinDel($id = 0)
    {
        $res = db('join')
            ->delete($id);
        if($res)
        {
            $this->success('修改删除成功！','heart/About/join');
        }else{
            $this->error('删除职位失败！');
        }
    }

    /**
     * 异步修改排序
     */
    public function sort($id,$sort)
    {
        $res = db('join')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/About/join');
        }else{
            $this->error('没有被修改！');
        }
    }

}