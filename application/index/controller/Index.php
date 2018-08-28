<?php
namespace app\index\controller;

use think\Request;

class Index extends Main
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * 官网首页
     * @return mixed
     */
    public function index()
    {
        //获取轮播图
        $banner = parent::getBanner();
        //获取产品分类
        $procate = db('pro_cate')
            ->where('is_show',1)
            ->order('sort,id')
            ->field('id,name,abs,thumb,title,alt')
            ->select();
        //获取客户评价
        $say = db('pj')
            ->where('is_show',1)
            ->order('sort,id')
            ->limit(5)
            ->field('id,name,content,thumb,title,alt')
            ->select();
        //获取新闻
        //1.获取轮播图新闻（4条）
        $pNews = db('news')
            ->order('sort,id desc')
            ->limit(4)
            ->select();
        $lNews = db('news')
            ->order('sort,id desc')
            ->limit(4)
            ->select();
        //获取知识问答
        $ask = db('ask')
            ->order('sort,id desc')
            ->field('id,ques,anser')
            ->limit(6)
            ->select();
        $this->assign([
            'banner' => $banner,
            'procate'=> $procate,
            'say'    => $say,
            'pNews' => $pNews,
            'lNews' => $lNews,
            'ask'   => $ask
        ]);
        return $this->fetch();
    }


}
