<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/30 13:55 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Db;
use think\Request;

class Product extends Base
{
    protected $url;
    protected $type = 2;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign('url',$this->url);
    }

    /**
     * 产品分类列表页
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cate()
    {
        //分类
        $cate = db('pro_cate')
            ->order('sort,id')
            ->where('is_show',1)
            ->select();
        $this->assign([
            'cate' => $cate,
        ]);
        return $this->fetch();
    }


    /**
     * 产品分类添加
     * @return mixed
     */
    public function cateAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file'])){unset($data['file']);}
            $res = db('pro_cate')
                ->insert($data);
            if($res)
            {
                $this->success('添加分类成功！','heart/Product/cate');
            }else{
                $this->error('添加分类失败！');
            }
        }
        return $this->fetch();
    }


    /**
     * 产品分类编辑
     * @param int $id
     * @return mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function cateEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            if(isset($data['file'])){unset($data['file']);}
            $res = db('pro_cate')
                ->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改分类成功！','heart/Product/cate');
            }else{
                $this->error('修改分类失败！');
            }
        }
        $cateInfo = db('pro_cate')
            ->where('id',$id)
            ->limit(1)
            ->find();
        $this->assign([
            'cateInfo' => $cateInfo,
        ]);
        return $this->fetch();
    }

    /**
     * 产品分类删除
     * @param int $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function cateDel($id = 0)
    {
        Db::table('h_pro_cate')
            ->where('id',$id)
            ->delete();
        $dtlArr = Db::table('h_pro')
            ->where('cid',$id)
            ->column('id');
        if($dtlArr)
        {
            Db::table('h_pro_dtl')
                ->where('pid','in',$dtlArr)
                ->delete();
            Db::table('h_pro')
                ->where('cid',$id)
                ->delete();
        }
        $this->success('分类删除成功！','heart/Pro/cate');
    }


    public function cateSort($id,$sort)
    {
        $res = db('pro_cate')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Product/cate');
        }else{
            $this->error('没有被修改！');
        }
    }


    public function proAdd($rr = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $content = $data['content'];

            $data['ctime'] = strtotime($data['ctime']);
            $data['addtime'] = time();
            $data['uid']   = session('id');
            unset($data['file']);
            unset($data['content']);

            $r_data['uid'] = $data['uid'];
            $r_data['addtime'] =  $data['addtime'];
            $r_data['type'] = $this->type;
            Db::startTrans();
            try{

                $pid = Db::name('pro')->insertGetId($data);

                Db::name('pro_dtl')->insert(['content'=>$content,'pid'=>$pid]);

                $r_data['rid'] = $pid;
                Db::name('record')->insert($r_data);
                // 提交事务
                Db::commit();
                $this->success('添加产品成功！','heart/Product/lists');
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error('产品未添加，请重试！');
            }
        }
        //查询新闻分类
        $cate = db('pro_cate')
            ->where('is_show',1)
            ->field('id,name')
            ->select();
        $this->assign([
            'cate' => $cate
        ]);
        return $this->fetch();
    }


    /**
     * 产品列表页
     * @return mixed
     */
    public function lists($cid = 0)
    {
        if($cid == 0)
        {
            $db = Db::table('h_pro')
                ->order('sort,id')
                ->where('is_show',1)
                ->field('id,sort,name,uid,thumb,abs,ctime,is_show');
        }else{
            $db = Db::table('h_pro')
                ->order('sort,id')
                ->where('cid',$cid)
                ->where('is_show',1)
                ->field('id,sort,name,uid,thumb,abs,ctime,is_show');
        }
        $proList = parent::_page($db,6, $cid);

        //查询产品分类
        $cate = db('pro_cate')
            ->where('is_show',1)
            ->field('id,name')
            ->select();
        $this->assign([
            'proList' => $proList,
            'cate' => $cate,
            'cid'  => $cid
        ]);
        return $this->fetch();
    }


    public function proEdit($id = 0)
    {
        if (request()->isPost()) {
            $data = input('post.');

            $content = $data['content'];

            $data['ctime'] = strtotime($data['ctime']);

            unset($data['file']);
            unset($data['content']);

            Db::startTrans();
            try {

                Db::name('pro')->where('id', $id)->update($data);

                Db::name('pro_dtl')->where('pid', $id)->update(['content' => $content]);
                // 提交事务
                Db::commit();
                $this->success('修改产品成功！', 'heart/Product/lists');
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error('产品没有被修改，请重试！');
            }
        }

        //分类
        $cate = db('pro_cate')
            ->where('is_show',1)
            ->field('id,name')
            ->select();
        $proInfo = db('pro')
            ->alias('p')
            ->join('pro_dtl d','p.id=d.pid')
            ->field('p.*,d.content,d.pid')
            ->where('p.id',$id)
            ->find();
        $this->assign([
            'proInfo' => $proInfo,
            'cate'     => $cate
        ]);
        return $this->fetch();
    }

    public function proDel($id = 0)
    {
        $thumb = db('pro')->where('id',$id)
            ->value('thumb');
        if($thumb)
        {
            $fileName = ROOT_PATH . '/public' . $thumb;
            if(file_exists($fileName))
            {
                unlink($fileName);
            }
        }

        Db::startTrans();
        try{

            Db::name('pro')->where('id',$id)->delete();

            Db::name('pro_dtl')->where('pid',$id)->delete();
            // 提交事务
            Db::commit();
            $this->success('删除产品成功！','heart/Product/lists');
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error('产品没有被删除，请重试！');
        }

    }

    /**
     * 异步修改排序
     */
    public function sort($id,$sort)
    {
        $res = db('pro')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/Product/lists');
        }else{
            $this->error('没有被修改！');
        }
    }
}