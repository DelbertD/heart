/**
 * +----------------------------------------------------------------------
 * |Description:
 * +----------------------------------------------------------------------
 * |Company：西安一笔一画科技有限公司
 * +----------------------------------------------------------------------
 * |Author：guosj
 * +----------------------------------------------------------------------
 * |CreatTime:2018/7/3
 * +----------------------------------------------------------------------
 */
$(function(){
    //监听滚动事件
    $(window).scroll(function () {
        //改变导航栏的样式
        var winPos = $(window).scrollTop();
        var headerH = $("#header").height();
        if(winPos>headerH){
            $(".secondHeader").addClass("activeHeader");
        }else{
            $(".secondHeader").removeClass("activeHeader");
        }
    });

    /*===================手机端导航的消失与出现=====================*/
    $("#navToggleIcon").click(function(){
        if($("#navToggleIcon").hasClass("glyphicon-align-justify")){
            $("#navToggleIcon").removeClass("glyphicon-align-justify");
            $("#navToggleIcon").addClass("glyphicon-remove");
        }else{
            $("#navToggleIcon").addClass("glyphicon-align-justify");
            $("#navToggleIcon").removeClass("glyphicon-remove");
        }
        $('body').toggleClass('nav-open');
    });

    /*===============================返回顶部=====================*/
    var top = $("#top");
    top.click(function(){
        $("html,body").animate({scrollTop:0},500);
    });

    /*==============================图片4/3====================================*/
    $(".IMG").height(0.75*$(".IMG").width());

    //手机端按钮导航
    $('.nav-toggle').click(function () {
        $('body').toggleClass('nav-open');
    });
});