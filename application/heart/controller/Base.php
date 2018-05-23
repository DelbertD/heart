<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/22 15:47 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->getComVar();
    }

    public function getComVar()
    {
        $controller = request()->controller();
        $action = request()->action();
    }
}