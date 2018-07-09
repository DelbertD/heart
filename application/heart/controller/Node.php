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



use think\Request;

class Node extends Base
{
    protected $nodeDb;
    protected $url;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->nodeDb = new \app\common\model\Node();
        $this->url = $request->url();
        $this->assign('url',$this->url);
    }

    /**
     * 节点列表页
     */
    public function lists()
    {

        //获取节点
        $node = $this->nodeDb->getAllForTree();
        $this->assign('node',$node);
        return $this->fetch();
    }

    /**
     * 添加后台导航
     */
    public function add()
    {
        if (request()->isPost())
        {
            $data = input('post.');
            if(!isset($data['pid']) || $data['pid'] ==0)
            {
                $res = db('tree')
                    ->where('pid',0)
                    ->select();
                if($res)
                {
                    $this->error('顶级栏目已经存在，不能添加');
                }else{
                    $data['pid'] = 0;
                    $res = db('tree')->insert($data);
                    if($res){
                        $this->success('栏目添加成功！');
                    }else{
                        $this->error('栏目添加失败！');
                    }
                }
            }else{
                $res = db('tree')->insert($data);
                if($res){
                    $this->success('栏目添加成功！');
                }else{
                    $this->error('栏目添加失败');
                }
            }
        }
        //获取所有icon
        $icons = $this->getIcons();
        $this->assign([
           'icons' => $icons,
        ]);
        return $this->fetch();
    }


    /**
     * 修改节点
     */
    public function edit($id)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $res = db('tree')->where('id',$id)
                ->update($data);
            if($res){
                $this->success('修改节点成功！','heart/Node/lists');
            }else{
                $this->error('修改节点失败！');
            }
        }

        //当前节点信息
        $node = db('tree')
            ->where('id',$id)
            ->limit(1)
            ->find();
        $noderes = db('tree')
            ->where('lev','<',$node['lev'])
            ->select();
        $nodeTree = arr2tree($noderes,0);
        //获取所有icon
        $icons = $this->getIcons();

        $this->assign([
            'node' =>$node,
            'nodeTree' => $nodeTree,
            'icons'=>$icons
        ]);
        return $this->fetch();
    }


    /**
     * 删除节点
     */
    public function del($id)
    {
        $res = db('tree')->where('id',$id)
            ->whereOr('pid',$id)
            ->delete();
        if($res){
            $this->success('删除节点成功！','heart/Node/lists');
        }else{
            $this->error('删除节点失败！');
        }
    }

    /**
     * 异步修改排序
     */
    public function sortChange($id,$sort)
    {
        $res = db('tree')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Node/lists');
        }else{
            $this->error('没有被修改！');
        }
    }

    public function getParNode($lev = 0)
    {
        $node = db('tree')
            ->where('lev','<',$lev)
            ->select();
        $nodetree = arr2tree($node,0);
        $str = '';
        foreach($nodetree as $v)
        {
            $str .= "<option value='" . $v['id'] . "'>" . $v['__name'] . "</option>";
        }
        return ['str'=>$str];
    }

}