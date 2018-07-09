<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/19 14:27 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class Abc extends Base
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

    public function publish()
    {
        //获取所有记录
        return $this->fetch();
    }


    public function charts($btime = NULL , $etime = NULL)
    {
        if($btime != NULL && $etime != NULL) {
            $sTime = strtotime($btime);
            $bigTime = strtotime($etime);
            $rec = db('record')
                ->where('addtime', '>', $sTime)
                ->where('addtime', '<', $bigTime)
                ->order('uid,type')
                ->select();
            $user = db('admin')->order('id')->column('name');
            $ids = db('admin')->order('id')->column('id');
            $data = charts_data($rec, $ids, $user);
        }else{
            $rec = db('record')->order('type')->select();

            //获取所有用户
            $user = db('admin')->order('id')->column('name');
            //所有用户id
            $ids = db('admin')->order('id')->column('id');
            $data = charts_data($rec,$ids,$user);
        }
        return $data;
    }
}