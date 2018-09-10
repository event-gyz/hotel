/*-------------------------------------------------------------------------
 * 版权所有：北京光宇在线科技有限责任公司
 * 作者：李根
 * 联系方式：ligen@gyyx.cn
 * 创建时间： 2014/4/16 
 * 版本号：v1.0

 * 功能： 公共弹出层方法

 * -------------------------------------------------------------------------*/

/*创建弹出层*/
function alertMsg(js_Msg_title, js_Msg_info, fn) {
    var alertMsgHtml = '<a data-toggle="modal" href="#js_Msg" style="display:none;" class="js_Msg"></a>'+
                        '<div class="modal fade" id="js_Msg">'+
                        '  <div class="modal-dialog">'+
                        '      <div class="modal-content">'+
                        '          <div class="modal-header">'+
                        '             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'+
                        '             <h4 class="modal-title js_Msg_title">' + js_Msg_title +
                        '             </h4>' +
                        '        </div>'+
                        '        <div class="modal-body">'+
                        '            <p class="js_Msg_info" style="color:red;">' + js_Msg_info +
                        '            </p>'+
                        '       </div>'+
                        '      <div class="modal-footer">'+
                        '          <button type="button" class="btn btn-default close_js_Msg" data-dismiss="modal">关闭</button>'+
                        '      </div>'+
                        '  </div>'+
                        ' </div>'+
                        '</div>';
    $("body").append(alertMsgHtml);
    $(".js_Msg").trigger("click");
    $(".close_js_Msg , .close").unbind().bind("click",function () {
        $("js_Msg_info").html("");
        if (fn) {
            fn();
        }
    });
};
//取消或关闭弹层清空表单数据
$(function () {
    $(".close_js_Msg , .close").unbind().bind("click", function () {
        $(this).parent().parent().find(".form-control").val("");
        var allselects = $(this).parent().parent().find("select");//关闭弹层清空input
        //关闭弹层初始化select为第一项
        for (var i = 0; i < allselects.length; i++) {
            allselects[i].options[0].selected = true;
        }
        $(".js_Message").empty();
        $(".error").empty();
    });
});