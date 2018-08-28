/**
 * +----------------------------------------------------------------------
 * |Description:
 * +----------------------------------------------------------------------
 * |Company：西安一笔一画科技有限公司
 * +----------------------------------------------------------------------
 * |Author：guosj
 * +----------------------------------------------------------------------
 * |CreatTime:2018/8/27
 * +----------------------------------------------------------------------
 */
/***********分享按钮************/
window._bd_share_config={
    "common":{
        "bdSnsKey":{},
        "bdText":"",
        "bdMini":"2",
        "bdMiniList":false,
        "bdPic":"",
        "bdSize":"16",
        //分享摘要
        'bdDesc':'一心一意分享摘要',
        'render':false
    },
    "share":{

    },
    "image":{
        /*要分享的图片  加上一个data-tag="imageSharePreview" 不分享的不加该属性*/
        "tag" : "imageSharePreview",
        viewType : 'list',
        viewPos : 'top',
        viewColor : 'black',
        viewSize : '16',
        "viewList":["qzone","tsina","tqq","renren","weixin"],
        "viewText":"分享到："
    },
    "selectShare":{
        "bdContainerClass":null,
        "bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]
    }
};
with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];