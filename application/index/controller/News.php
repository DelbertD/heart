<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/14 16:13 	  
// +----------------------------------------------------------------------

namespace app\index\controller;


use think\Request;

class News extends Main
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 父类方法重载
     */
    public function getInfo()
    {

        parent::getInfo(); // TODO: Change the autogenerated stub
        $this->title = 'news';
    }

    public function index($cid = 0)
    {
        if($cid == 0)
        {
            $cid = db('news_cate')
                ->order('sort,id')
                ->limit(1)
                ->value('id');
        }
        //分页获取新闻列表
        $db = db('news')
            ->where('is_show',1)
            ->where('pid',$cid)
            ->order('sort,id')
            ->field('id,name,abs,uid,addtime,thumb,title,alt');
        $news = parent::_page($db,10);
        //获取新闻分类
        $cateInfo = db('news_cate')
            ->order('sort,id')
            ->select();

        $this->assign([
            'cateInfo'  => $cateInfo,
            'news'      => $news,
            'cid'       => $cid,
        ]);
        return $this->fetch();
    }
}