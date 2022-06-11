//弹窗从边缘弹出3秒后自动收回
function Toast(msg, callback) {
    //如果有该弹窗正在显示,等待弹窗消失
    if (Toast.isShow) {
        Toast.callback = shownew;
        return;
    }
    var $toast = $('#toast');
    if ($toast.length == 0) {
        $toast = $('<div id="toast"></div>');
        $toast.appendTo($('body'));
    }
    $toast.html(msg);
    $toast.show();
    setTimeout(function() {
        $toast.hide();
        if (callback) callback(msg, callback);
    }, 3000);
}

function shownew(msg, callback) {
    Toast(msg, callback);
}