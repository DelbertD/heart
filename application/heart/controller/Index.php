<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/21 13:38 	  
// +----------------------------------------------------------------------
namespace app\heart\controller;

use think\Db;

class Index extends Base {


    //后台首页
    public function index()
    {
        return $this->fetch();
    }

    //首页环境信息页面
    public function sys()
    {
        $version = Db::query('select version()');
        $this->assign([
            'app_name'  => '西安一心一意后台管理系统',
            'app_ver'   => 'Version 2.0',
            'mysql_ver' => $version[0]['version()'],
            'pro_name'  => '西安一心一意医疗康复官网',
            'team'      => '西安一笔一画科技有限公司PHP软件研发小组',
        ]);
        return $this->fetch();
    }
}