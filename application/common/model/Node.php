<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/24 10:32 	  
// +----------------------------------------------------------------------

namespace app\common\model;


use think\Db;
use think\Model;

class Node extends Model
{
    protected $pk = 'id';
    protected $table = 'h_tree';

    /**
     * 获取所有节点
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAll()
    {
        $data =  $this->order('sort,id')->select();
        if($data) {
            $data = collection($data)->toArray();
        }
        return $data;
    }

    public function getShowAll()
    {
        $data =  $this->order('sort,id')
            ->where('is_show',1)
            ->select();
        if($data) {
            $data = collection($data)->toArray();
        }
        return $data;
    }

    /**
     * 获取所有节点树
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllForTree()
    {
        $data = $this->getAll();
        return arr2tree($data,0);
    }


    /**
     * 获取测测菜单格式数据
     */
    public function getNavTree()
    {
        $data = $this->getShowAll();
        return arr2navtree($data,'id','pid');
    }
}