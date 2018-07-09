<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/4 14:42 	  
// +----------------------------------------------------------------------

namespace app\index\controller;


use think\Controller;
use think\Request;

class Main extends Controller
{
    protected $title;

    protected $desc;

    protected $keywords;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $nav = $this->getNav();
        $this->getInfo();
        $this->assign([
            'nav'      => $nav,
            'title'    => $this->title,
            'desc'     => $this->desc,
            'keywords' => $this->keywords
        ]);
    }


    public function getNav()
    {
        return db('nav')
            ->order('sort,id')
            ->field('id,name,tips,url')
            ->select();
    }

    public function getInfo()
    {
        $contro = request()->controller();
        $action = request()->action();
        if($contro && $action)
        {
            $search = 'index/' . $contro . '/' . $action;
            $res = db('nav')->where('url',$search)
                ->find();
            if($res)
            {
                $this->title = $res['title'];
                $this->keywords = $res['keywords'];
                $this->desc = $res['desc'];
            }
        }
    }


    /**
     * 获取轮播图
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    protected function getBanner()
    {
        $res = db('banner')
            ->order('sort,id')
            ->select();
        return $res;
    }

    /**
     * 数据集分页
     */
    protected function _page($db , $limit)
    {

        if(!$db){return null;}
        $result = [];
        $list = $db->paginate($limit,false);
        $page = $list->render();
        $result['list'] = $list;
        $result['page'] = $page;
        return $result;
    }


}