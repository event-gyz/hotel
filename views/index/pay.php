<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- 是否启动webapp功能，会删除默认的苹果工具栏和菜单栏。 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <!-- 当启动webapp功能时，显示手机信号、时间、电池的顶部导航栏的颜色。默认值为default（白色），可以定为black（黑色）和black-translucent（灰色半透明）。这个主要是根据实际的页面设计的主体色为搭配来进行设置。 -->
    <meta name="format-detection" content="telephone=no, email=no"/>
    <title>订单提交</title>
    <link rel="stylesheet" href="/css/iconfont.css"/>
    <link rel="stylesheet" href="/css/base.css"/>
    <link rel="stylesheet" href="/css/swiper-3.4.2.min.css"/>
    <link rel="stylesheet" href="/css/hotel-common.css"/>
    <link rel="stylesheet" href="/css/pay.css"/>

    <script src="/js/jquery-1.8.2.js"></script>
    <script src="/js/jquery.form.js"></script>
</head>
<body>
<div id="app">
    <div id="main-box">
        <div class="pay">
            <div class="pay-top">
                <!--nav-title-end-->
                <div class="nav-title" style="background: none;">
                    <i class="iconfont f20" style="color: #fff;">&#xe605;</i>
                    <h2 style="background: none;color: #fff;">预订信息填写</h2></div>
                <!--nav-title-end-->
                <div class="pay-top-box">
                    <div class="name"><?= $hotel_info['hotel_name'] ?></div>
                    <div class="info">
                        <p class="title"><?= $hotel_info['hotel_address'] ?></p>
                        <p class="date">
                            <span><b>入住：</b><?= date('m月d日', strtotime($_GET['startDate'])) ?></span><span><b>离店：</b><?= date('m月d日', strtotime($_GET['endDate'])) ?></span><span>共<?php echo (strtotime($_GET['endDate']) - strtotime($_GET['startDate'])) / 86400 ?>
                                晚</span>
                        </p>
                        <p class="room-style">
                            <span><?= $room_info['room_name'] ?></span><span><?= $bed_info['bed_name'] ?></span><span><?= $bed_info['breakfast'] ?></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="pay-con-box">
                <form id="orderForm" method="post" enctype="multipart/form-data" name="orderForm">
                    <input type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>" name="_csrf">
                    <table border="0" cellspacing="0">
                        <tr>
                            <td class="left">房间数</td>
                            <td class="room-name" colspan="2">
                            <span>
                                <input type="number" maxlength="50" value="1" placeholder="房间数量" class="conname"
                                       id="num" name="num">
                            </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="left">入住人</td>
                            <td class="room-name" colspan="2">
                                <span><input type="text" maxlength="6" placeholder="填写住客姓名" name="name"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="left">联系人</td>
                            <td class="room-name" colspan="2">
                                <span><input type="text" maxlength="6" placeholder="请输入联系人姓名" name="content_name"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="left">联系手机</td>
                            <td colspan="2">
                                <input type="text" placeholder="11位手机号码"  name="content_phone">
                            </td>
                        </tr>
                        <input type="hidden" value="<?=$_GET['startDate']?>" name="check_in_time">
                        <input type="hidden" value="<?=$_GET['endDate']?>" name="check_out_time">
                        <input type="hidden" value="<?=$bed_info['id']?>" name="bed_id">
                        <input type="hidden" value="<?=$bed_info['room_id']?>" name="room_id">
                        <input type="hidden" value="<?=$hotel_info['id']?>" name="hotel_id">
                    </table>
                </form>
            </div>
            <div class="pay-terms">
                <p><span>预订须知：</span>此为向代理商申请的特殊价格，我们会在一小时以内提供预订结果，请您耐心等待，到达酒店前台后请直接报入住客人姓名办理入住。</p>
                <p><span>取消规则：</span>订单确认后不可变更取消，若未入住将收取您全额房费，订单不确认将全额退款至您的付款账户。附加服务费用将与房费同时扣除或返还。
                </p>

            </div>
        </div>
        <div class="pay-info">
            <p class="left">
                <span class="info-left">总价:<i class="min">¥</i><i
                        class="max j-tot-price"><?= (strtotime($_GET['endDate']) - strtotime($_GET['startDate'])) / 86400 * $bed_info['price'] ?></i></span>
            </p>
          <span class="right has_buy">立即预订</span>
        </div>
    </div>
</div>
<script>

    $("#num").change(function () {
        var night = <?=(strtotime($_GET['endDate']) - strtotime($_GET['startDate'])) / 86400?>;
        var price = <?= $bed_info['price']?>;
        var num = $('#num').val();
        $('.j-tot-price').text(num * night * price);
    })

    $('.has_buy').click(function () {
        $('#orderForm').ajaxSubmit(      //ajax方式提交表单
            {
                url: '/index/pay-order',
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {
                },
                success: function (data) {
                    if (data.errorno == "1") {
                        window.location.href = "/index/pay-page?orderId="+data.data;
                    } else {
                        alert(data.msg);
                    }
                },
                clearForm: false,//禁止清楚表单
                resetForm: false //禁止重置表单
            });
    })
</script>
</body>
</html>




