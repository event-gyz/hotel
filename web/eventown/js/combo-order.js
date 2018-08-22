/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */

// $(document).on("click", "#buy-btn", function() {
//             $.alert("很抱歉，您于该公司的角色无付款权限，请您邀请公司管理员或财务角色前往企业中心— 我的订单— 特惠商品订单菜单查看订单详情并完 成付款操作。 ", " 提示 ");
//             });

/*$('#buy-btn').on('click', function() {

    //window.open('payment.html')
});*/

$(".weui_select").on("change", function() {
    var valId=$(this).prop('value');
    $('#identity').val(valId);
    // alert($('.weui_select').val());
});

$("#buy-btn").on("click", function() {
    if ($('#buy-btn').hasClass('bg-muted')) {
        return false
    }
    var name = $('#order-name').val(),
        mobile = $('#order-phone').val();
    if (name == '') {
        $.alert('请填写联系人姓名');
        return false;
    }
    if (mobile == '') {
        $.alert('请填写手机号码');
        return false;
    }
    if (!/^(13[0-9]|14[0-9]|15[0-9]|17[0-9]|18[0-9])\d{8}$/i.test(mobile)) {
        $.alert('手机号码格式不正确');
        return false;
    }

    var deflutVal=$('.order-select').find('.weui_select option').val();
    $('#identity').val(deflutVal);
    $.alert($('.order-select').html(), " 请选择订单发布身份 ", function () {
        $.ajax({
            url: '/combo/pay',
            type: 'post',
            dataType: 'json',
            data: $('#submitOrder').serialize(),
            success: function (data) {
                if (data.code == 200) {
                    //$('#payForm input').val(data.data);
                    window.location.href = "/Pay_order/weixin_pay/"+data.data;
                    //$('#payForm').submit();
                } else if (data.code == 300) {
                    $.alert('检测到当前商品有信息更新，请您仔细核对后下单', function () {
                        window.location.reload();
                    });
                } else if (data.code == 500) {
                    $.alert("很抱歉，您于该公司的角色无付款权限，请您邀请公司管理员或财务角色前往企业中心— 我的订单— 特惠商品订单菜单查看订单详情并完 成付款操作。");
                } else if (data.code == 400) {
                    $.alert(data.msg);
                }
            }
        });
    });
});

$("#time").datetimePicker({
    min: "2012-12-12",
    max: "2022-12-12"
});

//判断是否同意会唐网预定条款
var weui_check = $('.weui_check');
weui_check.change(function () {
    if (weui_check.is(':checked')) {
        $('#buy-btn').removeClass('bg-muted');
    } else {
        $('#buy-btn').addClass('bg-muted');
    }
});


