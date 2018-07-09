/**
 * 选择图标
 * @param obj
 */
function iconChose(obj)
{
    var icon = obj.className;

    var nameArr = icon.split(" ");

    var iconName = nameArr[1];

    $("input[name='icon']").val(iconName);
    $('#ic').window('close');
}


function goBack()
{
    history.go(-1);
}

function myformatter(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}
function myparser(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
}