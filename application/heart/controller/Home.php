<?php
// +----------------------------------------------------------------------
// |Description: 	首页管理类
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/25 15:06 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class Home extends Base
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

    /**
     * 轮播图管理页面
     * @return mixed
     */
    public function banner()
    {
        //查询轮播
        $db = db('banner')
            ->order('sort,id');
        $bannerList = parent::_page($db,4);
        $this->assign([
            'bannerList' => $bannerList
        ]);
        return $this->fetch();
    }

    /**
     * 添加轮播图
     * @return mixed
     */
    public function bannerAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file']))
            {
                unset($data['file']);
            }
            $res = db('banner')
                ->insert($data);
            if($res)
            {
                $this->success('轮播上传成功！','heart/Home/banner');
            }else{
                $this->error('上传失败！');
            }
        }
        return $this->fetch();
    }


    /**
     * 编辑轮播图
     * @param int $id
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function bannerEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file']))
            {
                unset($data['file']);
            }
            $res = db('banner')
                ->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('轮播修改成功！','heart/Home/banner');
            }else{
                $this->error('修改失败！');
            }
        }
        //获取当前轮播信息
        $bannerInfo = db('banner')
            ->where('id',$id)
            ->limit(1)->find();
        $this->assign([
            'bannerInfo'    => $bannerInfo
        ]);
        return $this->fetch();
    }


    /**
     * 删除轮播图
     * @param int $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function bannerDel($id = 0)
    {
        //查询图片路径
        $thumb = db('banner')->where('id',$id)
            ->value('thumb');
        if($thumb)
        {
            $fileName = ROOT_PATH . '/public' . $thumb;
            if(file_exists($fileName))
            {
                unlink($fileName);
            }
        }
        $res = db('banner')
            ->where('id',$id)
            ->delete();
        if($res)
        {
            $this->success('轮播删除成功！','heart/Home/banner');
        }else{
            $this->error('删除失败！');
        }
    }


    /**
     * 导航列表页面
     * @return mixed
     */
    public function nav()
    {
        $navInfo = db('nav')
            ->order('sort,id')
            ->select();
        $this->assign([
            'navInfo'   => $navInfo
        ]);
        return $this->fetch();
    }


    /**
     * 添加导航页面
     * @return mixed
     */
    public function navAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $res = db('nav')
                ->insert($data);
            if($res)
            {
                $this->success('导航添加成功！','heart/Home/nav');
            }else{
                $this->error('添加失败！');
            }
        }
        return $this->fetch();
    }

    public function navEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $res = db('nav')
                ->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('导航修改成功！','heart/Home/nav');
            }else{
                $this->error('修改失败！');
            }
        }
        $oldNav = db('nav')
            ->where('id',$id)
            ->find();
        $this->assign([
            'oldNav'    => $oldNav
        ]);
        return $this->fetch();
    }


    public function navDel($id = 0)
    {
        $res = db('nav')
            ->where('id',$id)
            ->limit(1)
            ->delete();
        if($res)
        {
            $this->success('导航删除成功！','heart/Home/nav');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 异步修改排序
     */
    public function navSort($id,$sort)
    {
        $res = db('nav')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Home/nav');
        }else{
            $this->error('没有被修改！');
        }
    }
}