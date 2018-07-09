/**
 * +----------------------------------------------------------------------
 * |Description:
 * +----------------------------------------------------------------------
 * |Company：西安一笔一画科技有限公司
 * +----------------------------------------------------------------------
 * |Author：guosj
 * +----------------------------------------------------------------------
 * |CreatTime:2018/5/22
 * +----------------------------------------------------------------------
 */
$(function(){
    //监听滚动事件
    $(window).scroll(function () {
        //改变导航栏的样式
        var winPos = $(window).scrollTop();
        if(winPos>60){
            $("#header").addClass("headerActive");
        }else{
            $("#header").removeClass("headerActive");
        }
    });
    $(window).resize(function() {
        w();
    });
    w();
    function w(){
        var windowW = $(window).width();
        if(windowW>920){
            console.log("电脑端");
            $("#header .navContainer").removeClass("mobileHeader");
            $("#header #logo").removeClass("mobileLogo");
            $("#header #navBar").removeClass("mobileNav");
            $("#header #navBar").addClass("pcNav");
            $(".mobileBtn").hide();
        }else{
            console.log("手机端");
            $("#header .navContainer").addClass("mobileHeader");
            $("#header #logo").addClass("mobileLogo");
            $("#header #navBar").addClass("mobileNav");
            $(".mobileBtn").show();
            $(window).scroll(function () {
                //改变导航栏的样式
                var winPos = $(window).scrollTop();
                if(winPos>60){
                    $(".mobileBtn").css("color","#565656");
                }else{
                    $(".mobileBtn").css("color","#fff");
                }
            });
        }
    }
    var windowH = $(document).height();
    $(".mobileNav").height(windowH);
    $("#navBar").height(windowH);
    $(".hideNav").height(windowH);
    //手机端  二级菜单的显示与隐藏
    $(".mobileBtn").click(function(){
        $(".mobileNav").animate({left:0});
        $(".hideNav").animate({right:0});
    });
    $(".hideNav").click(function(){
        $(".mobileNav").animate({left:-600});
        $(".hideNav").animate({right:-500});
    })
});