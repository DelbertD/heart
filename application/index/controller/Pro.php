<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/6 13:51 	  
// +----------------------------------------------------------------------

namespace app\index\controller;


use think\Request;

class Pro extends Main
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }

    public function index($cid = 0)
    {
        if($cid == 0)
        {
            $cid = db('pro_cate')
                ->order('sort,id')
                ->limit(1)
                ->value('id');
        }
        //获取产品分类
        $cateInfo = db('pro_cate')
            ->order('sort,id')
            ->select();
        //获取产品列表
        $db = db('pro')
            ->where('is_show',1)
            ->where('cid',$cid)
            ->order('sort,id')
            ->field('id,name,abs,uid,addtime,thumb,title,alt');
        $pro = parent::_page($db,12);
        $this->assign([
            'cateInfo' => $cateInfo,
            'pro'   => $pro,
            'cid'       => $cid
        ]);
        return $this->fetch();
    }
}