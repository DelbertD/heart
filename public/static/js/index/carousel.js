/**
 * Created by jf on 2016/11/11.
 */
window.onload = function () {
    var wrap = document.getElementById("wrap");
    var slide = document.getElementById("slide");
    var ul = slide.children[0];
    var lis = ul.children;
    var arrow = document.getElementById("arrow");
    var arrLeft = document.getElementById("arrLeft");
    var arrRight = document.getElementById("arrRight");
    wrap.onmouseover = function () {
        animate(arrow, {"opacity": 1});
    };
    wrap.onmouseout = function () {
        animate(arrow, {"opacity": 0});
    };
   console.log(document.body.clientWidth);
    if(document.body.clientWidth<920){
        var config = [
            {
                "width": 100,
                "top": 20,
                "left": 10,
                "opacity": 0.2,
                "zIndex": 2
            },
            {
                "width": 200,
                "top": 70,
                "left": 0,
                "opacity": 0.8,
                "zIndex": 3
            },
            {
                "width": 250,
                "top": 100,
                "left": 50,
                "opacity": 1,
                "zIndex": 4
            },
            {
                width: 200,
                top: 70,
                left: 150,
                opacity: 0.8,
                zIndex: 3
            },
            {
                "width": 100,
                "top": 20,
                "left": 200,
                "opacity": 0.2,
                "zIndex": 2
            }
        ];

    }else{
        var config = [
            {
                "width": 400,
                "top": 20,
                "left": 50,
                "opacity": 0.2,
                "zIndex": 2
            },
            {
                "width": 600,
                "top": 70,
                "left": 0,
                "opacity": 0.8,
                "zIndex": 3
            },
            {
                "width": 800,
                "top": 100,
                "left": 200,
                "opacity": 1,
                "zIndex": 4
            },
            {
                width: 600,
                top: 70,
                left: 600,
                opacity: 0.8,
                zIndex: 3
            },
            {
                "width": 400,
                "top": 20,
                "left": 750,
                "opacity": 0.2,
                "zIndex": 2
            }
        ];
    }
    function assign() {
        for (var i = 0; i < lis.length; i++) {
            animate(lis[i], config[i], function () {
                flag = true;
            });
        }
    }
    assign();
    arrRight.onclick = function () {
        if (flag) {
            flag = false;
            config.push(config.shift());
            assign();
        }
    };
    arrLeft.onclick = function () {
        if (flag) {
            flag = false;
            config.unshift(config.pop());
            assign();
        }
    };
    var tt = setInterval(function(){
        if (flag) {
            flag = false;
            config.push(config.shift());
            assign();
        }
    },2000);


    //鼠标滑过清楚定时器
    slide.onmouseout = function(){
        setInterval(function(){
            if (flag) {
                flag = false;
                config.push(config.shift());
                assign();
            }
        },2000)
    };
    slide.onmouseover = function(){
        window.clearInterval(tt);
    };

    var flag = true;



};