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
    <title>支付订单</title>
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
                    <h2 style="background: none;color: #fff;">支付订单</h2></div>
                <!--nav-title-end-->
                <div class="pay-top-box">
                    <div class="name">
                        <?= $hotel_info['hotel_name'] ?>

                    </div>

                    <div class="info">
                        <p class="title"><?= $hotel_info['hotel_address'] ?></p>
                        <p class="date">
                            <span><b>入住：</b><?= $order_info['check_in_time'] ?></span>
                            <span><b>离店：</b><?= $order_info['check_out_time'] ?></span>
                            <span><?=$order_info['nights'] ?>晚</span>
                            <span><?=$order_info['num'] ?>间</span>
                        </p>
                        <p class="room-style">
                            <span>应付金额</span>
                            <span style="color:red">¥<span style="font-size:20px"><?= $order_info['total_price'] ?></span></span>
                        </p>
                    </div>

                </div>

            </div>

            <div class="pay-terms">
                <p><span>预订须知：</span>此为向代理商申请的特殊价格，我们会在一小时以内提供预订结果，请您耐心等待，到达酒店前台后请直接报入住客人姓名办理入住。</p>
                <p><span>取消规则：</span>订单确认后不可变更取消，若未入住将收取您全额房费，订单不确认将全额退款至您的付款账户。附加服务费用将与房费同时扣除或返还。
                </p>

            </div>
        </div>
        <div class="pay-info">
            <p class="center payMoney">立即支付</p>
        </div>
    </div>
</div>
<script>

    var wxJsApiData = <?=$wxJsApiData?>;
    function onBridgeReady()
    {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            $.parseJSON(wxJsApiData.resultData),
            function(res){
                if(res.err_msg == "get_brand_wcpay_request:ok" ){
                    window.location.href="/wxpay/paysuccess/"+<?=$order_info['id']?>;
                }

            }
        );
    }

    $('.payMoney').click(function () {
        if(!wxJsApiData.resultCode){
            alert(wxJsApiData.resultType+","+wxJsApiData.resultMsg+"!");
            return false;
        }
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
        }else{
            onBridgeReady();
        }
    })
</script>
</body>
</html>




