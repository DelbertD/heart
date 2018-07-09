<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/28 17:36 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Controller;
use think\Request;

class Login extends Controller
{
    protected $url;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign('url',$this->url);
    }

    /**
     * 登录页面
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $name = $data['name'];
            $pass = sha1($data['pass']);
            //检测信息是否正确
            $userInfo = db('admin')
                ->where([
                    'name'=>$name,
                    'pass'=>$pass
                ])->find();
            if($userInfo)
            {
                session('user',$userInfo['name']);
                session('id',$userInfo['id']);
                //
                return $this->redirect('heart/Index/index');
            }
        }
        return $this->fetch();
    }

    /**
     * 退出操作
     */
    public function logout()
    {
        session(null);
        return $this->success('退出成功！');
    }

}