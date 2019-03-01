<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name=keywords content="找场地，上会唐 拥用20万会场资源，覆盖全国301个城市">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- 是否启动webapp功能，会删除默认的苹果工具栏和菜单栏。 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
    <!-- 当启动webapp功能时，显示手机信号、时间、电池的顶部导航栏的颜色。默认值为default（白色），可以定为black（黑色）和black-translucent（灰色半透明）。这个主要是根据实际的页面设计的主体色为搭配来进行设置。 -->
    <meta name="format-detection" content="telephone=no, email=no"/>
    <title>酒店列表</title>
    <script src="/js/jquery-1.8.2.js"></script>
    <link rel="stylesheet" href="/css/base.css"/>
    <link rel="stylesheet" href="/css/hotel-common.css"/>
<!--    <link rel="stylesheet" href="/css/lists.css"/>-->
    <link rel="stylesheet" href="/css/calendar.css"/>
    <link rel="stylesheet" href="/css/index-date.css"/>
    <style type="text/css">
        html,body{
            margin:0;padding:0;height:100%;width:100%;
        }
        footer{
            background:#F2F3F6;max-width: 750px;width: 100%;height: 1rem;
        }

        /* å…¬å…±æ ·å¼è¡¨css */
        html,body {
            color: #333;
            margin: 0;
            height: 100%;
            font-family: "Myriad Set Pro","Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-weight: normal;
        }

        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        a {
            text-decoration: none;
            color: #000;
        }

        a, label, button, input, select {
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        img {
            border: 0;
        }

        body {
            background: #fff;
            color: #666;
        }

        html, body, div, dl, dt, dd, ol, ul, li, h1, h2, h3, h4, h5, h6, p, blockquote, pre, button, fieldset, form, input, legend, textarea, th, td {
            margin: 0;
            padding: 0;
        }

        a {
            text-decoration: none;
            color: #08acee;
        }

        button {
            outline: 0;
        }

        img {
            border: 0;
        }

        button,input,optgroup,select,textarea {
            margin: 0;
            font: inherit;
            color: inherit;
            outline: none;
        }

        li {
            list-style: none;
        }

        a {
            color: #666;
        }

        .tab-nav-item.tab-active a {
            color: #000000;
            font-weight: bold;
        }

        .tab-nav-item a {
            display: inherit;
            color: inherit;
            font-size: 0.8rem;
            color: #464646;
        }

        .aui-well-item {
            padding: 20px 15px 20px 20px;
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .aui-well-item-hd {
            margin-right: .4em;
            width: 19px;
            height: 19px;
            line-height: 19px;
            text-align: center;
        }

        .aui-well-item-hd img {
            width: 100%;
            max-height: 100%;
            vertical-align: top;
            display: block;
            border: none;
            margin-top: 3px;
        }

        .aui-well-item-bd {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            min-width: 0;
        }

        .aui-well-item-bd h3 {
            color: #333;
            font-size: 0.9rem;
            position: relative;
            /* padding-left: 20px; */
            font-weight: normal;
            padding-bottom: 0;
            text-align: left;
        }

        .aui-well-item-fr {
            font-size: 0.85rem;
            text-align: right;
            color: #999999;
            padding-right: 25px;
            position: relative;
        }


        .aui-mail-product {
            background: #f7f7f7;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .aui-mail-product-item {
            /* padding: 15px; */
            position: relative;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
        }

        .aui-mail-product-item-hd {
            margin-right: .8em;
            /*width: 70px;*/
            height: 10px;
            line-height: 10px;
            padding-left:30px
            /*text-align: center;*/
        }

        .aui-mail-product-item-hd img {
            width: 100%;
            max-height: 100%;
            vertical-align: top;
        }

        .aui-mail-product-item-bd {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
            min-width: 0;
        }

        .aui-mail-product-item-bd p {
            color: #404040;
            font-size: 13px;
            line-height: 1.4;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .aui-mail-payment {
            padding: 10px 15px;
            position: relative;
            text-align: right;
            font-size: 0.8rem;
            color: #333;
            overflow: hidden;
            display: block;
        }

        .aui-mail-payment p em {
            font-style: normal;
        }

        .aui-mail-payment p i {
            font-size: 1.3rem;
            font-style: normal;
        }

        .aui-mail-payment:after {
            content: '';
            position: absolute;
            z-index: 2;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            border-bottom: 1px solid #e2e2e2;
            -webkit-transform: scaleY(0.5);
            transform: scaleY(0.5);
            -webkit-transform-origin: 0 100%;
            transform-origin: 0 100%;
        }

        .aui-mail-button {
            padding: 15px 20px 15px 0;
            overflow: hidden;
        }

        .aui-mail-button a {
            background: none;
            border: 1px solid #f0250f;
            color: #f0250f;
            font-size: 0.8rem;
            border-radius: 40px;
            display: block;
            padding: 2px 14px;
            display: inline-block;
            float: right;
            margin-left: 8px;
        }

        .divHeight {
            background: #f0f2f5;
            width: 100%;
            height: 10px;
        }


        .btn_menubar_bottom {

            position: fixed;
            bottom: 0;
            width: 100%;
            height: 55px;
            line-height: 55px;
        }

        .btn_menubar_bottom , img{
            margin: 0 auto;
        }
        .btn_menubar_bottom > .menu_left{
            background: white;
            float:left;
            width:50%;
            text-align:center;
        }
        .btn_menubar_bottom > .menu_right{
            background: #4FA9FF;
            float:right;
            width:50%;
            text-align:center;
        }
        .aui-mail-product-item-hd > img{
            width:100%;			/* ... */
            height:100%;
            display:block;
        }
    </style>
</head>
<body>
<div class="list-main" id="app">
    <div id="main-box">
        <div>
            <!--head-->

            <script type="text/javascript" src="/js/jquery.min.js"></script>
<!--            <script type="text/javascript" src="/js/date.js"></script>-->
<!--            <script type="text/javascript" src="/js/date2.js"></script>-->

            <!--list-->
            <div class="list-main-list">
                <!--style-->
                <?php if(is_array($order_list) && !empty($order_list)){?>
                <?php foreach ($order_list as $value) { ?>
                    <div class="tab-item">
                        <a href="javascript:void(0);" class="aui-well-item aui-well-item-clear">

                            <div class="aui-well-item-bd">
                                <h3><?= $value['hotel_name']?></h3>
                            </div>
                            <span class="aui-well-item-fr">已付款</span>
                        </a>
                        <div class="aui-mail-product-item-hd">
                            <p><?= $value['hotel_address']?></p>
                        </div>
                        <br/>
                        <div class="aui-mail-product-item-hd">
                            <p><?= $value['room_name']?> <?= $value['bed_name']?></p>
                        </div>
                        <br/>
                        <div class="aui-mail-product-item-hd">
                            <p><?= $value['name']?></p>
                        </div>
                        <br/>
                        <div class="aui-mail-product-item-hd">
                            <p><?= str_replace(" 00:00:00","",$value['check_in_time'])?>至<?= str_replace(" 00:00:00","",$value['check_out_time'])?> <?= $value['nights']?>晚/<?= $value['num']?>间</p>
                        </div>

                        <a href="javascript:;" class="aui-mail-payment">

                            <p>
                                间 合计: ￥<i><?= $value['total_price']?></i>
                            </p>
                        </a>
                    </div>
                    <div class="divHeight"></div>
                <?php } ?>
                <?php }else{?>
                    <span style="text-align: center;width:100%">暂无订单</span>
                <?php }?>
                <!--style-end-->
            </div>
            <!--list-->
        </div>
    </div>
</div>
<div class="btn_menubar_bottom">
    <span class="menu_left">
        <a href="/index/list" class="">
            <img src="/images/hotel1.png" style="display: flex;width: 35.496px; height: 60.496px;"/>
        </a>
    </span>
    <span class="menu_right">
        <a href="/index/my" class="" >
            <img src="/images/my-order1.png" style="display: flex; width: 35.496px; height: 60.496px;"/>
        </a>
    </span>
</div>

<!---公用样式--->

<script>
    $(".go_detail").click(function () {
        var hotel_id = $(this).attr('data-hotelid');
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var NumDate = $('.NumDate').text();    //共多少晚
        window.location.href='/index/detail?startDate='+startDate+'&endDate='+endDate+'&NumDate='+NumDate+'&hotelId='+hotel_id;
    }) ;

</script>
</body>
</html>
