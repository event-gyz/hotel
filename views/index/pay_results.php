<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name=keywords content="找场地，上会唐 拥用20万会场资源，覆盖全国301个城市">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- 是否启动webapp功能，会删除默认的苹果工具栏和菜单栏。 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <!-- 当启动webapp功能时，显示手机信号、时间、电池的顶部导航栏的颜色。默认值为default（白色），可以定为black（黑色）和black-translucent（灰色半透明）。这个主要是根据实际的页面设计的主体色为搭配来进行设置。 -->
    <meta name="format-detection" content="telephone=no, email=no" />
    <title>支付结果_会唐网</title>
    <script src="/js/jquery-1.8.2.js"></script>
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/pay_results.css" />
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div class="pay-results">
        <div>
            <h2>支付订单</h2>
            <?php if ($status == 1) { ?>
            <!--成功-->
            <div class="content success">
                <p class="pay-title"><i class="iconfont">&#xe69c;</i>支付成功</p>
                <p class="hotel-name"><?php echo $hotel_name; ?></p>
                <p class="order-num">订单号：<?php echo $order_no; ?></p>
                <p class="date"><?php echo $create_time ? date('Y-m-d H:i:s', $create_time) : ''; ?></p>
                <p class="button">
                    <a class="default" href="/hotel/index">返回首页</a>
                    <a class="success" href="/user/hotelOrderDetail?id=<?php echo $order_id; ?>">查看订单</a>
                </p>
            </div>
            <?php } else { ?>
            <!--失败-->
            <div class="content error">
                <p class="pay-title"><i class="iconfont">&#xe672;</i>支付失败</p>
                <p class="hotel-name"><?php echo $hotel_name; ?></p>
                <p class="order-num">订单号：<?php echo $order_no; ?></p>
                <p class="date"><?php echo $create_time ? date('Y-m-d H:i:s', $create_time) : ''; ?></p>
                <p class="button">
                    <a class="default" href="/user/hotelOrderDetail?id=<?php echo $order_id; ?>">查看订单</a>
                    <a class="error" href="/pay/fast_yeepay?order_id=<?php echo $order_id; ?>&h_id=<?php echo $h_id; ?>&c_id=<?php echo $c_id; ?>">立即支付</a>
                </p>
            </div>
            <?php } ?>
        </div>
        <div class="info-room-hot">
            <ul class="title">
                <li class="line"></li>
                <li class="text">推荐参考</li>
            </ul>
            <ul class="list-box" style="display: none" id="app">
                <li  class="style" v-for="item in mapHotel">
                    <a :href="'/hotel/info?h_id='+item.place_id+'&c_id='+item.ctrip_id+'&location='+location+'&start_date='+start_date+'&end_date='+end_date">
                        <p class="img"><img :src="item.main_pic_url" ></p>
                        <p class="text-title" v-text="item.place_name"></p>
                        <p class="price"><i>¥</i>{{item.roomMinPrice}}<span>起</span></p>
                    </a>
                </li>

                <input type="hidden" id="location" value="<?php echo $location; ?>">
            </ul>
        </div>
        <div><img style="width: 100%" src="/public/hotel/images/bottom-img.png"></div>
        <div id="global_login"></div>
    </div>
    <script src="/public/hotel/js/jquery.js"></script>
    <script src="/public/hotel/js/moment.min.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script>
        var VM = new Vue({
            el:'#app',
            data:{
                location: $('#location').val(),
                start_date:moment().add(0, 'day').format('YYYY-MM-DD'),
                end_date:moment().add(1, 'day').format('YYYY-MM-DD'),
                mapHotel: []
            },
            mounted: function(){
                var _this = this;
                this.$nextTick(function () {
                    _this.mapHotelFn();
                })
            },
            methods: {
                //周边酒店
                mapHotelFn: function(){
                    var _this = this;
                    $.ajax({
                        url:api_url+'/hotel/get_similar_hotels',
                        type:'post',
                        dataType: 'json',
                        data:{
                            location:_this.location
                        },
                        success: function(responseData){
                            $('#app').show();
                            $('#global_login').hide();
                            if(!responseData.errorno){
                                _this.mapHotel = responseData.data.rows;
                            }else{
                                util.m.alert(responseData.msg);
                            }
                        }
                    });
                }
            }
        });
    </script>
</body>
</html>
