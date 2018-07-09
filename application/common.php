<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 获取节点树函数
 */
if( ! function_exists('arr2tree'))
{
    function arr2tree($data , $pid = 0 ,&$result = [] , $space = 0)
    {
        if(!is_array($data))
        {
            return false;
        }
        ++$space;
        foreach($data as $k=>$v)
        {
            if($v['pid']==$pid)
            {
                $v['__name'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$space).'|--'.$v['name'];
                $v['__flag'] = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$space).'|--'.$v['flag'];
                $result[] = $v;
                arr2tree($data,$v['id'],$result,$space);
            }
        }
        return $result;
    }
}

if(!function_exists('arr2navtree'))
{
    function arr2navtree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root=1) {
        $tree = array();// 创建Tree
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }

            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[$data[$pk]] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }
}

/**
 * 查询函数
 */
if(!function_exists('get_value'))
{
    function get_value($field = '',$db = '',$findfield = '',$value = '')
    {
        return db($db)->where($findfield,$value)->value($field);
    }
}


if(!function_exists('charts_data'))
{
    function charts_data($result = [] , $limit , $x = [])
    {
        $data['user'] = $x;
        if(!$result){
            return false;
        }
        foreach($result as $key=>$value)
        {
            $t[$value['type']][$value['uid']][] = $value['id'];
        }

        foreach($limit as $id){
            foreach($t as $key=>$value){
                foreach($value as $k=>$v){
                    if($id == $k)
                    {
                        $t[$key][$k] = count($v);
                    }
                    if(!array_key_exists($id,$value)){
                        $t[$key][$id] = 0;
                    }
                }
            }
        }
        foreach($t as $k=>$v)
        {
            foreach($v as $key=>$value){
                $re[$k][] = $value;
            }
        }

        foreach($re as $k=>$v)
        {
            $data['type'][]=config('rec.'.$k);
        }

        $data['data'] = $re;

        return json_encode($data);
    }
}

