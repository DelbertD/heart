<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/6/12 16:44 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Request;

class System extends Base
{
    protected $url;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign([
            'url'   =>  $this->url
        ]);
    }

    public function lists()
    {
        $user = db('admin')
            ->field('id,name,nickname,log_ip,log_time,n_num,a_num')
            ->select();
        $this->assign([
            'user'   =>  $user
        ]);
        return $this->fetch();
    }

    public function userAdd()
    {

        if(request()->isPost())
        {
            $data = input('post.');
            if($data['pass'] != $data['nopass'])
            {
                $this->error('密码和确认密码不一致！请重试。');
            }
            unset($data['nopass']);
            $data['pass'] = sha1($data['pass']);
            $res = db('admin')
                ->insert($data);
            if($res)
            {
                $this->success('添加账户成功！','heart/System/lists');
            }else{
                $this->error('没有账户被添加！请重试。');
            }
        }
        return $this->fetch();
    }


    public function userEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if($data['pass'] != $data['nopass']){$this->error('新密码与确认新密码不一致！');}
            unset($data['nopass']);
            $data['pass'] = sha1($data['pass']);
            $res = db('admin')
                ->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改账户信息成功！','heart/System/lists');
            }else{
                $this->error('没有账户信息被修改！请重试。');
            }
        }
        $user = db('admin')
            ->where('id',$id)
            ->limit(1)
            ->find();
        $this->assign([
            'user'=>$user
        ]);
        return $this->fetch();
    }

    public function checkPass($id = 0 , $pass = '')
    {
        $oldPass = db('admin')
            ->where('id',$id)
            ->value('pass');
        if(sha1($pass)==$oldPass)
        {
            $this->success('','heart/System/userEdit',['id'=>$id]);
        }else{
            $this->error('原始密码错误！');
        }
    }


    public function userDel($id = 0)
    {
        if($id == session('id')){$this->error('您不能删除您自己！');}
        $res = db('admin')
            ->where('id',$id)
            ->delete();
        if($res)
        {
            $this->success('删除用户成功','heart/System/lists');
        }else{
            $this->error('没有用户被删除！');
        }
    }

}