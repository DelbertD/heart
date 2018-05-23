<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/22 17:46 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


class Node extends Base
{
    /**
     * 节点列表页
     */
    public function lists()
    {
        return $this->fetch();
    }

    /**
     * 添加节点
     */
    public function add()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            $res = db('node')->insert($data);
            if($res){
                return $this->success('ok');
            }else{
               return  $this->error('no');
            }
        }
        return $this->fetch();
    }

    /**
     * 获取父级节点列表
     */
    public function getParent($level)
    {
       $nodeArr =  db('node')
            ->where('level','<',$level)
            ->order('id asc')
            ->select();
       //构造树

        //构造字符串
        $nodeStr = '';
        foreach ($nodeArr as $k=>$v)
        {
            $nodeStr .= '<option value="' . $v['id'] . '">' . $v['title'] . '</option>';
        }
        return $nodeStr;
    }
}