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

    /**
     * 产品列表页
     * @param int $cid
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
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
            ->field('id,name,abs,uid,ctime,addtime,thumb,title,alt');
        $pro = parent::_page($db,3);
        $this->assign([
            'cateInfo' => $cateInfo,
            'pro'   => $pro,
            'cid'       => $cid
        ]);
        return $this->fetch();
    }

    /**
     * 产品详情页
     * @param int $id
     * @return mixed
     */
    public function show($id = 0)
    {
        //查询相关产品详细信息
        $pro = db('pro')
            ->alias('p')
            ->join('pro_dtl pd','p.id=pd.pid')
            ->where('p.id',$id)
            ->where('is_show',1)
            ->limit(1)
            ->find();
        $this->assign([
            'pro'   => $pro
        ]);
        return $this->fetch();
    }
}