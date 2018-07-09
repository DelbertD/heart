<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/28 10:03 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class Company extends Base
{
    protected $url;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign('url',$this->url);
    }


    /**
     * 公司信息管理页
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function show()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            unset($data['file']);
            $data['time'] = strtotime($data['time']);
            //查询
            $res = db('company')
                ->find();
            if($res) {
                $result = db('company')
                    ->where('id', $res['id'])
                    ->update($data);
            }
            if($result)
            {
                $this->success('成功！');
            }else{
                $this->error('失败！');
            }
        }
        //获取当前公司信息
        $comInfo = db('company')
            ->limit(1)
            ->find();
        if($comInfo)
        {
            $comInfo['time'] = date('Y-m-d',$comInfo['time']);
            $this->assign([
                'comInfo' => $comInfo
            ]);
        }
        return $this->fetch();
    }
}