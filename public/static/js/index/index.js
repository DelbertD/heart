/**
 * +----------------------------------------------------------------------
 * |Description:
 * +----------------------------------------------------------------------
 * |Company：西安一笔一画科技有限公司
 * +----------------------------------------------------------------------
 * |Author：guosj
 * +----------------------------------------------------------------------
 * |CreatTime:2018/6/29
 * +----------------------------------------------------------------------
 */
$(function(){
    var bannerHeight = $(".bannerImg").height();
    var bodyWidth  = $(document.body).width();
    var bannerMain = $("#bannerMain");
    if(bodyWidth>800){
        bannerMain.height('100vh');
    }else{
        $("#banner").height(bannerHeight);
        $(".bannerImg").height('100%');
    }
    /*===================客户评价=====================*/
    var Year = new Array(
        [
            "1要使整个人生都过得舒适、愉快，这是不可能的，因为人类必须具备一种能应付逆境的态度。--卢梭"
        ],
        [
            "2重复别人所说的话，只需要教育；而要挑战别人所说的话，则需要头脑。——玛丽·佩蒂博恩·普尔"
        ],
        [
            "3人生就是学校。在那里，与其说好的教师是幸福，不如说好的教师是不幸。——海贝尔"
        ],
        [
            "4对一个人来说，所期望的不是别的，而仅仅是他能全力以赴和献身于一种美好事业。——爱因斯坦"
        ],
        [
            "5心如镜，虽外景不断变化，镜面却不会转动，这就是一颗平常心，能够景转而心不转。"
        ],
        [
            "6一份耕耘，一份收获，付出就有回报永不遭遇过失败，因我所碰到的都是暂时的挫折。"
        ]

    );
    _PreLoadImg([
        "/static/img/index/m2yy_btn.png"
    ],function(){
        // 初始化
        $(".a-part").each(function(){
            $(this).height(330);
            FullBg($(this), $(this).find("img.bg"))
        });
        $(".about-fo .main").css("top", ($(window).height() - 572) / 2 );
        $(".about-fo .box").each(function(){
            $(this).find(".box-in").css("padding-top", 138 - $(this).find(".box-in").height() / 2 )
        });
        var $In    = $(".about-fo .detail .in"),
            InBl   = true,
            a      = 0,
            b      = 0,
            $FoUl  = $(".about-fo .list ul"),
            $FoLi  = $(".about-fo .list li");

        $FoUl.width($FoLi.width() * $FoLi.length);
        $FoLi.eq(0).addClass("cur");

        var cura  = $(".about-fo .list li.cur").index();
        $(".about-fo .box:last .box-in p").html(Year[cura]);
        $(".about-fo .box:last .box-in").show().css("padding-top", 138 - $(".about-fo .box:last .box-in").height() / 2 );
        //自动循环
        function jump(){
            if(!InBl){
                return
            }
            InBl = false;
            var n = $(".about-fo .list li.cur").index();
            if(n == 5){
                n=0;
            }else{
                n++;
            }
            $FoLi.removeClass("cur").eq(n).addClass("cur");
            a = $(this).index(),
                b = 0
            if($(this).index() < 5){
                $FoUl.stop().animate({marginLeft: 0}, 500)
            }
            if($(this).index() != 0){
                $(".about-fo .prev").stop().fadeIn(500);
            }else{
                $(".about-fo .prev").stop().fadeOut(500);
            }
            if($(this).index() > n){
                var $list = '<div class="box poa dn"><div class="box-in dn"><p></p></div></div>';
                $In.find(".box").eq(0).before($list);
                $In.find(".box").eq(0).css({
                    y : -96,
                    scale : 0.55,
                    opacity : 0.08
                });
                $In.find(".box").eq(4).stop().animate({
                    top : 26,
                    opacity : 1
                }, 500).prev().stop().transition({
                    y : 0,
                    scale : 1,
                    opacity : 1
                }, 500).find(".box-in").stop().fadeIn(600).find("p").html(Year[a]);
                $In.find(".box").eq(3).find(".box-in").css("padding-top", 88 - $In.find(".box").eq(3).find(".box-in").height() / 2)
                $In.find(".box").eq(2).stop().transition({
                    y : -32,
                    scale : 0.85,
                    opacity : 0.4
                }, 500).prev().stop().transition({
                    y : -64,
                    scale : 0.7,
                    opacity : 0.2
                }, 500).prev().stop().fadeIn(500, function(){
                    $In.find(".box").eq(4).remove();
                    InBl = true
                })
            }else{
                var $list = '<div class="box poa fif dn"><div class="box-in dn"><p></p></div></div>'
                $In.find(".box:last").after($list);
                $In.find(".box").eq(0).stop().fadeOut(500).next().stop().transition({
                    y : - 96,
                    scale : 0.55,
                    opacity : 0.08
                }, 500).next().stop().transition({
                    y : -64,
                    scale : 0.7,
                    opacity : 0.2
                }, 500).next().stop().transition({
                    y : -32,
                    scale : 0.85,
                    opacity : 0.4
                }, 500).next().stop().fadeIn(600).find(".box-in").stop().fadeIn(600).find("p").html(Year[n]);
                $In.find(".box").eq(4).stop().animate({
                    top : 0,
                    opacity : 1
                }, 500, function(){
                    $In.find(".box:first").remove();
                    $In.find(".box").eq(3).siblings().find(".box-in").hide().find("p").html("");
                    InBl = true
                }).find(".box-in").css("padding-top", 138 - $In.find(".box").eq(4).find(".box-in").height() / 2)
            }
        }
        var time = setInterval(jump,3000);
        var evaluateBox = $("#evaluate");
        evaluateBox.mouseover(function (){
            clearInterval(time);
        }).mouseout(function (){
            time = setInterval(jump, 3000);
        });
        evaluateBox.mouseover(function (){
            clearInterval(time);
        });
        console.log($FoLi);
        $FoLi.click(function(){
            if(!InBl){
                return
            }
            InBl = false;
            var n = $(".about-fo .list li.cur").index();
            $(this).addClass("cur").siblings().removeClass("cur");
            a = $(this).index(),
                b = 0
            if($(this).index() < 5){
                $FoUl.stop().animate({marginLeft: 0}, 500)
            }
            if($(this).index() != 0){
                $(".about-fo .prev").stop().fadeIn(500);
            }else{
                $(".about-fo .prev").stop().fadeOut(500);
            }
            if($(this).index() > n){
                var $list = '<div class="box poa dn"><div class="box-in dn"><p></p></div></div>'
                $In.find(".box").eq(0).before($list);
                $In.find(".box").eq(0).css({
                    y : -96,
                    scale : 0.55,
                    opacity : 0.08
                });
                $In.find(".box").eq(4).stop().animate({
                    top : 26,
                    opacity : 1
                }, 500).prev().stop().transition({
                    y : 0,
                    scale : 1,
                    opacity : 1
                }, 500).find(".box-in").stop().fadeIn(600).find("p").html(Year[a]);
                $In.find(".box").eq(3).find(".box-in").css("padding-top", 88 - $In.find(".box").eq(3).find(".box-in").height() / 2)
                $In.find(".box").eq(2).stop().transition({
                    y : -32,
                    scale : 0.85,
                    opacity : 0.4
                }, 500).prev().stop().transition({
                    y : -64,
                    scale : 0.7,
                    opacity : 0.2
                }, 500).prev().stop().fadeIn(500, function(){
                    $In.find(".box").eq(4).remove();
                    InBl = true
                })
            }else{
                var $list = '<div class="box poa fif dn"><div class="box-in dn"><div class="time"></div><p></p></div></div>'
                $In.find(".box:last").after($list);
                $In.find(".box").eq(0).stop().fadeOut(500).next().stop().transition({
                    y : - 96,
                    scale : 0.55,
                    opacity : 0.08
                }, 500).next().stop().transition({
                    y : -64,
                    scale : 0.7,
                    opacity : 0.2
                }, 500).next().stop().transition({
                    y : -32,
                    scale : 0.85,
                    opacity : 0.4
                }, 500).next().stop().fadeIn(600).find(".box-in").stop().fadeIn(600).find("p").html(Year[a]);
                $In.find(".box").eq(4).stop().animate({
                    top : 0,
                    opacity : 1
                }, 500, function(){
                    $In.find(".box:first").remove();
                    $In.find(".box").eq(3).siblings().find(".box-in").hide().find(".time").html("").siblings().html("")
                    InBl = true
                }).find(".box-in").css("padding-top", 138 - $In.find(".box").eq(4).find(".box-in").height() / 2)
            }
        });
        var NewsBl;
        function aboutNews(n){
            if(!NewsBl){
                return
            }
            NewsBl = false;
            $(".about-fif .btn span").eq(n).addClass("cur").siblings().removeClass("cur");
            var $UlMark = $(".about-fif ul.mark");
            $UlMark.stop().animate({
                left : - 1182,
                opacity : 0
            }, 500, function(){
                $UlMark.css("left", -17).find("li").css({
                    left : 360,
                    opacity : 0
                });
                $(".about-fif ul").eq(n).css({
                    opacity : 1,
                    "z-index" : 2
                }).addClass("mark").siblings().removeClass("mark").css({
                    opacity : 0,
                    "z-index" : 1
                });
                Enter($(".about-fif ul").eq(n).find("li").eq(0), "left", 0, 3, 500, 350)
                setTimeout(function(){
                    NewsBl = true
                }, 1200)
            })
        }
        aboutNews(1);
    });
    //新闻轮播
    var num = 2;
    $(".num-box").children("li").mousemove(function(){
        var previousIndex = $(".num-box").children("li").index($(".active"));
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
        var currentIndex = $(".num-box").children("li").index($(this));
        if(currentIndex == previousIndex){
            return false;
        }else if(currentIndex > previousIndex){
            $(".pic-box").children("li").eq(currentIndex).css("top",230);
            $(".pic-box").children("li").eq(currentIndex).css("z-index",num++);
            $(".pic-box").children("li").eq(currentIndex).stop().animate({"top":"0"},1000);
        }else{
            $(".pic-box").children("li").eq(currentIndex).css("top",-230);
            $(".pic-box").children("li").eq(currentIndex).css("z-index",num++);
            $(".pic-box").children("li").eq(currentIndex).stop().animate({"top":"0"},1000);
        }
    });
    $(".pic-box").height($(".pic-box li").height());
    function newsBanners(){
        var numBoxLiLen = $(".numBoxLi").length;
        for(var i=0;i<numBoxLiLen;i++){
            if($(".numBoxLi").eq(i).hasClass("active")){
                var previousIndex = i;
            }
        }
        if((previousIndex+1) == numBoxLiLen){
            $(".numBoxLi").removeClass("active").eq(0).addClass("active");
            $(".pic-box").children("li").eq(0).css("top",230);
            $(".pic-box").children("li").eq(0).css("z-index",num++);
            $(".pic-box").children("li").eq(0).stop().animate({"top":"0"},1000);
        }else if((previousIndex+1) < numBoxLiLen){
            $(".numBoxLi").removeClass("active").eq(previousIndex+1).addClass("active");
            $(".pic-box").children("li").eq(previousIndex+1).css("top",230);
            $(".pic-box").children("li").eq(previousIndex+1).css("z-index",num++);
            $(".pic-box").children("li").eq(previousIndex+1).stop().animate({"top":"0"},1000);
        }
    }
    var newsTime = setInterval(newsBanners,3000);
    var newsBanner = $("#newsBanner");
    newsBanner.mouseover(function (){
        clearInterval(newsTime);
    }).mouseout(function (){
        newsTime = setInterval(newsBanners, 3000);
    });
    newsBanner.mouseover(function (){
        clearInterval(newsTime);
    });
});
