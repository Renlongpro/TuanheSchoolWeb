//弹窗从边缘弹出3秒后自动收回
var ErrorInfo = {
    4000:"未知错误",
    4001:"API信息为空",
    4002:"没有登陆",
    4003:"API信息错误",
    4004:"邮箱错误",
    4101:"已经签到过了",
    1001:"验证码出错",
    1002:"信息有误,请检查",
    1003:"信息填写不合规,请修改",
    1004:"该邮箱已存在",
    1005:"您已登录账号,请退出后再来登录",
    1006:"信息为空",
    1007:"账号或密码错误",
    1008:"内容有非法特殊字符,如';{}\\/'等"
}
function UserApiShowBan(time,reason="违规"){
    var date = new Date(time * 1000);
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var hour = date.getHours();
    var minute = date.getMinutes();
    var second = date.getSeconds();
    var strTime = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    new $Msg({
        title:"提示",
        content:"账号已被封，解封时间为"+strTime+"\n原因:"+reason
    });
}
function GetApiInfo(data){
    if(data.substr(0,2)=="OK"){
        return data.substr(2);
    }else if(data.substr(0,4)=="INFO"){
        setTimeout(data.substr(4),0);
        return -2;
    }else{
        if(data==''){
            cocoMessage.error(" (无返回) "+"服务器未返回结果",3000);
        }else if(ErrorInfo[data]==undefined){
            cocoMessage.error(" ("+data+") "+未知结果,3000);
        }else cocoMessage.error(" ("+data+") "+ErrorInfo[data],3000);
        return -1;
    }
}
