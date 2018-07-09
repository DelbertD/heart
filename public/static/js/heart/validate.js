/**
 * +----------------------------------------------------------------------
 * |Description:
 * +----------------------------------------------------------------------
 * |Company：西安一笔一画科技有限公司
 * +----------------------------------------------------------------------
 * |Author：guosj
 * +----------------------------------------------------------------------
 * |CreatTime:2018/6/8
 * +----------------------------------------------------------------------
 */
//为表单的必填文本框添加提示信息（选择form中的所有后代input元素）
$("form :input.required").each(function () {
    //通过jquery api：$("HTML字符串") 创建jquery对象
    var $required = $("<strong class='high'>*</strong>");
    //添加到this对象的父级对象下
    $(this).parent().append($required);
});

//为表单元素添加失去焦点事件
$("form :input").blur(function(){
    var $parent = $(this).parent();
    $parent.find(".msg").remove(); //删除以前的提醒元素（find()：查找匹配元素集中元素的所有匹配元素）
    //验证必须
    if($(this).is(".required")){
        var requiredVal = $.trim(this.value); //原生js去空格方式：this.replace(/(^\s*)|(\s*$)/g, "")
        if(requiredVal == ""){
            var errorMsg = "请输入内容";
            $parent.append("<span class='msg onError'>" + errorMsg + "</span>");
        }
        else{
            var okMsg=" 输入正确";
            $parent.find(".high").remove();
            $parent.append("<span class='msg onSuccess'>" + okMsg + "</span>");
        }
    }
    //验证数字
    if($(this).is(".num")){
        var numeVal = $.trim(this.value); //原生js去空格方式：this.replace(/(^\s*)|(\s*$)/g, "")
        var ex = /^\d+$/;
        if(isNaN(numeVal)|| numeVal == "" || !ex.test(numeVal)){
            var errorMsg = "必须为正整数";
            $parent.append("<span class='msg onError'>*" + errorMsg + "</span>");
        }
        else{
            var okMsg=" 输入正确";
            $parent.find(".high").remove();
            $parent.append("<span class='msg onSuccess'>" + okMsg + "</span>");
        }
    }
    //验证邮箱
    if($(this).is(".email")){
        var emailVal = $.trim(this.value);
        var regEmail = /.+@.+\.[a-zA-Z]{2,4}$/;
        if(emailVal== "" || (emailVal != "" && !regEmail.test(emailVal))){
            var errorMsg = " 请输入正确的E-Mail住址！";
            $parent.append("<span class='msg onError'>*" + errorMsg + "</span>");
        }
        else{
            var okMsg=" 输入正确";
            $parent.find(".high").remove();
            $parent.append("<span class='msg onSuccess'>" + okMsg + "</span>");
        }
    }
    //验证长度
    if($(this).is(".len")){
        var lenVal = $.trim(this.value); //原生js去空格方式：this.replace(/(^\s*)|(\s*$)/g, "")
        var regName = /[~#^$@%&!*()<>:;'"{}【】  ]/;
        if(lenVal.length>150||lenVal.length==0){
            var errorMsg = "长度必须为150以内";
            $parent.append("<span class='msg onError'>*" + errorMsg + "</span>");
        }
        else{
            var okMsg=" 输入正确";
            $parent.find(".high").remove();
            $parent.append("<span class='msg onSuccess'>" + okMsg + "</span>");
        }
    }

    //验证手机号
    if($(this).is(".tel")){
        var telVal = $.trim(this.value); //原生js去空格方式：this.replace(/(^\s*)|(\s*$)/g, "")
        var regTel = /^1[345789]\d{9}$/;
        // || telVal.length < 11 || regTel.test(telVal)
        if(telVal == "" || telVal.length > 11 || !regTel.test(telVal)){
            var errorMsg = "请输入正确的手机号";
            $parent.append("<span class='msg onError'>*" + errorMsg + "</span>");
        }
        else{
            var okMsg=" 输入正确";
            $parent.find(".high").remove();
            $parent.append("<span class='msg onSuccess'>" + okMsg + "</span>");
        }
    }
}).keyup(function(){
    //triggerHandler 防止事件执行完后，浏览器自动为标签获得焦点
    $(this).triggerHandler("blur");
}).focus(function(){
    $(this).triggerHandler("blur");
});

//点击重置按钮时，通过trigger()来触发文本框的失去焦点事件
function submitFun(){
    $("form .required:input").trigger("blur");
    $("form .num:input").trigger("blur");
    $("form .email:input").trigger("blur");
    $("form .len:input").trigger("blur");
    $("form .tel:input").trigger("blur");
    var numError = $("form .onError").length;
    if(numError){
        return false;
    }
}
