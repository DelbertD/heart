<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/28 17:12 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Db;
use think\Request;

class News extends Base
{
    //url属性
    protected $url;
    protected $type = 1;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->url = $request->url();
        $this->assign('url',$this->url);
    }

    /**
     * 新闻分类列表页
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function cate()
    {
        //查找新闻分类
        $cate = db('news_cate')
            ->order('sort,id')
            ->where('is_show',1)
            ->select();
        $this->assign([
            'cate' => $cate
        ]);
        return $this->fetch();
    }

    /**
     * 添加新闻分类
     * @return mixed|string
     */
    public function cateAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');
            $res = db('news_cate')
                ->insert($data);
            if($res)
            {
                $this->success('添加分类成功！','heart/News/cate');
            }else{
                $this->error('添加分类失败！');
            }
        }
        return $this->fetch();
    }

    /**
     * 编辑新闻分类
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
            $res = db('news_cate')
                ->where('id',$id)
                ->update($data);
            if($res)
            {
                $this->success('修改分类成功！','heart/News/cate');
            }else{
                $this->error('修改分类失败！');
            }
        }
        $cateInfo = db('news_cate')
            ->where('id',$id)
            ->limit(1)
            ->find();
        $this->assign([
            'cateInfo' => $cateInfo,
        ]);
        return $this->fetch();
    }

    /**
     * 删除新闻分类
     * @param int $id
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function cateDel($id = 0)
    {
            Db::table('h_news_cate')
                ->where('id',$id)
                ->delete();
            $dtlArr = Db::table('h_news')
                ->where('pid',$id)
                ->column('id');
            if($dtlArr)
            {
                Db::table('h_news_dtl')
                    ->where('news_id','in',$dtlArr)
                    ->delete();
                Db::table('h_news')
                    ->where('pid',$id)
                    ->delete();
            }
            $this->success('分类删除成功！','heart/News/cate');
    }

    /**
     * 异步修改排序
     */
    public function cateSort($id,$sort)
    {
        $res = db('news_cate')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/News/cate');
        }else{
            $this->error('没有被修改！');
        }
    }


    /**
     * 新闻列表
     * @param int $pid
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists($pid = 0)
    {
        if($pid == 0)
        {
            $db = Db::table('h_news')
                    ->order('sort,id')
                    ->where('is_show',1)
                    ->field('id,sort,name,thumb,uid,addtime,pid,is_show');
        }else{
            $db = Db::table('h_news')
                ->order('sort,id')
                ->where('pid',$pid)
                ->where('is_show',1)
                ->field('id,sort,name,thumb,uid,addtime,pid,is_show');
        }
        $newsList = parent::_page($db,6, $pid);

        //查询新闻分类
        $cate = db('news_cate')
                    ->where('is_show',1)
                    ->field('id,name')
                    ->select();
        $this->assign([
            'newsList' => $newsList,
            'cate' => $cate,
            'pid'  => $pid
        ]);
        return $this->fetch();
    }


    /**
     * 添加新闻
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function newsAdd()
    {
        if(request()->isPost())
        {
            $data = input('post.');

            $data['addtime'] = time();
            $data['uid'] = session('id');
            $detail = $data['detail'];

            $r_data['uid'] = $data['uid'];
            $r_data['addtime'] = $data['addtime'];
            $r_data['type'] = $this->type;
            unset($data['file']);
            unset($data['detail']);

            Db::startTrans();
            try{

                $news_id = Db::name('news')->insertGetId($data);

                Db::name('news_dtl')->insert(['detail'=>$detail,'news_id'=>$news_id]);

                $r_data['rid'] = $news_id;
                Db::name('record')->insert($r_data);
                // 提交事务
                Db::commit();
                $this->success('添加新闻成功！','heart/News/lists');
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error('新闻没有被添加，请重试！');
            }
        }
        //查询新闻分类
        $cate = db('news_cate')
            ->where('is_show',1)
            ->field('id,name')
            ->select();
        $this->assign([
           'cate' => $cate
        ]);
        return $this->fetch();
    }


    /**
     * 编辑新闻
     * @param int $id
     */
    public function newsEdit($id = 0)
    {
        if(request()->isPost())
        {
            $data = input('post.');

            $data['addtime'] = time();
            $detail = $data['detail'];

            unset($data['file']);
            unset($data['detail']);

            Db::startTrans();
            try{

                Db::name('news')->where('id',$id)->update($data);

                Db::name('news_dtl')->where('news_id',$id)->update(['detail'=>$detail]);
                // 提交事务
                Db::commit();
                $this->success('修改新闻成功！','heart/News/lists');
            } catch (Exception $e) {
                // 回滚事务
                Db::rollback();
                $this->error('新闻没有被修改，请重试！');
            }

        }

        //分类
        $cate = db('news_cate')
            ->where('is_show',1)
            ->field('id,name')
            ->select();
        $newsInfo = db('news')
            ->alias('w')
            ->join('news_dtl d','w.id=d.news_id')
            ->field('w.*,d.detail,d.news_id')
            ->where('w.id',$id)
            ->find();
        $this->assign([
            'newsInfo' => $newsInfo,
            'cate'     => $cate
        ]);
        return $this->fetch();
    }


    public function newsDel($id = 0)
    {
        $thumb = db('news')->where('id',$id)
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

            Db::name('news')->where('id',$id)->delete();

            Db::name('news_dtl')->where('news_id',$id)->delete();
            // 提交事务
            Db::commit();
            $this->success('删除新闻成功！','heart/News/lists');
        } catch (Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error('新闻没有被删除，请重试！');
        }

    }

    /**
     * 异步修改排序
     */
    public function sort($id,$sort)
    {
        $res = db('news')
            ->where('id',$id)
            ->update(['sort'=>$sort]);
        if($res){
            $this->success('修改排序成功！','heart/News/lists');
        }else{
            $this->error('没有被修改！');
        }
    }


}