<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/7/10 14:44 	  
// +----------------------------------------------------------------------

namespace app\index\controller;


use think\Request;

class About extends Main
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }


    public function index()
    {
        //职位列表
        $joins = db('join')
            ->where('is_show',1)
            ->orderRaw('sort=0,sort')
            ->select();
        $count = count($joins);
        if($count%2 == 0){
            $res = db('join')
                ->where('is_show',1)
                ->orderRaw('sort=0,sort')
                ->limit(1)
                ->select();
            array_splice($joins,$count/2,0,$res);

        }
        $this->assign([
            'joins' => $joins,
        ]);
        return $this->fetch();
    }
}