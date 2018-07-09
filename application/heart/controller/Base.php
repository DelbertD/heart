<?php
// +----------------------------------------------------------------------
// |Description: 								     
// +----------------------------------------------------------------------
// |Company：西安一笔一画科技有限公司     					   	 
// +----------------------------------------------------------------------
// |Author：Delbert <18629435343@163.com>  	  
// +----------------------------------------------------------------------
// |CreatTime:2018/5/22 15:47 	  
// +----------------------------------------------------------------------

namespace app\heart\controller;


use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        //判断登陆
        $this->checkLogin();

        $leftmenu = $this->leftMenu();
        $title = $this->getTitle();
        $this->assign([
            'leftmenu' => $leftmenu,
            'title'  => $title
        ]);

    }


    /**
     * 左侧菜单栏
     * @return array
     */
    public function leftMenu()
    {
        $node = new \app\common\model\Node();
        $data = $node->getNavTree();
        return $data;
    }

    /**
     * 获取所有icons
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getIcons()
    {
       return db('icons')->select();
    }

    public function getTitle()
    {
        $controller = request()->controller();
        $action = request()->action();
        $contro = db('tree')
            ->where('flag',$controller)
            ->limit(1)
            ->value('name');
        $pid = db('tree')
            ->where('flag',$controller)
            ->limit(1)
            ->value('id');
        $act = db('tree')
            ->where('flag',$action)
            ->where('pid',$pid)
            ->limit(1)
            ->value('name');

        if(!$contro && !$act)
        {
            return NULL;
        }
        $title = '&nbsp;'. $contro . '&nbsp;/&nbsp;' . $act;
        return $title;
    }


    /**
     * 图片上传
     */
    public function upload()
    {
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file
            ->validate(['ext'=>'jpg,png,gif'])
            ->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $path = DS . 'uploads' . DS . $info->getSaveName();
            echo json_encode(['status'=>1,'msg'=>'上传成功','url'=>$path]);
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }
    }

    /**
     * 判断登陆
     */
    private function checkLogin()
    {
        if(!session('user'))
        {
            return $this->redirect('heart/Login/index');
        }
    }

    /**
     * 数据集分页
     */
    protected function _page($db , $limit , $pid = 0)
    {

        if(!$db){return null;}
        $result = [];
        $list = $db->paginate($limit,false,['query' => ['pid'=>$pid]]);
        $page = $list->render();
        $result['list'] = $list;
        $result['page'] = $page;
        return $result;
    }



}