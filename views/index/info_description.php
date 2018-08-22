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
    <title>酒店介绍_会唐网</title>
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/info_description.css" />
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div class="info-main-description" id="app">
        <!--nav-title-end-->
        <div class="nav-title"><i onclick="history.go(-1)" class="iconfont f20">&#xe605;</i><h2>酒店详情介绍</h2></div>
        <!--nav-title-end-->
        <!--banner-->
        <div class="info-main-description-banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="item in msg.pics"><img :src="item.pic_url" style="width:100%;height:220px;"></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="banner-title">
                <p class="title" v-text="msg.place_name">北京万程华府国际酒店<span>【{{msg.star_rate}}】</span></p>
                <p class="num swiper-count"><span>1/12</span>&nbsp;<i class="iconfont">&#xe60d;</i></p>
            </div>
        </div>
        <!--banner-end-->
        <!--酒店介绍-->
        <div class="info-main-description-box">
            <h2 class="info-main-description-box-title">酒店介绍</h2>
            <div class="hotel-info-desc" :style="{height:descHeight}" style="line-height:20px;" v-html="msg.place_desc"></div>
            <div class="show-more">
                <p class="tab-show" v-if="msg.place_desc.length>110" v-show="!isAllDesc" @click="showDesc('auto')" data-class="hotel-info" data-type="height"><span>展开全部</span>&nbsp;<i class="iconfont">&#xe610;</i></p>
                <p class="tab-show" v-show="isAllDesc" @click="showDesc('80px')" data-class="hotel-info" data-type="height"><span>收起</span>&nbsp;<i class="iconfont">&#xe60f;</i></p>
            </div>
        </div>
        <!--服务设施-->
        <div class="info-main-description-box">
            <h2 class="info-main-description-box-title">服务设施</h2>
            <ul class="hotel-facility">
                <li>
                    <h3><i class="iconfont">&#xe6ab;</i>客房服务</h3>
                    <p v-if="msg.feature.accomodations.length">
                        <span v-for="item in msg.feature.accomodations">{{item}}</span>
                    </p>
                    <p v-else><span>数据维护中...</span></p>
                </li>
                <!--li v-show="isAllServer">
                    <h3><i class="iconfont">&#xe650;</i>会议室服务</h3>
                    <p v-if="msg.feature.acitivities.length">
                        <span v-for="item in msg.feature.acitivities">{{item}}</span>
                    </p>
                    <p v-else><span>数据维护中...</span></p>
                </li-->
                <li v-show="isAllServer">
                    <h3><i class="iconfont">&#xe7dd;</i>基础服务设施</h3>
                    <p v-if="msg.feature.general.length">
                        <span v-for="item in msg.feature.general">{{item}}</span>
                    </p>
                    <p v-else><span>数据维护中...</span></p>
                </li>
                <li v-show="isAllServer">
                    <h3><i class="iconfont">&#xe6aa;</i>服务设施</h3>
                    <p v-if="msg.feature.services.length">
                        <span v-for="item in msg.feature.services">{{item}}</span>
                    </p>
                    <p v-else><span>数据维护中...</span></p>
                </li>
            </ul>
            <div class="show-more">
                <p class="tab-show" data-class="hotel-facility" data-type="length" v-show="!isAllServer" @click="isAllServer = !isAllServer"><span>展开全部</span>&nbsp;<i class="iconfont">&#xe610;</i></p>
                <p class="tab-show" data-class="hotel-facility" data-type="length" v-show="isAllServer" @click="isAllServer = !isAllServer"><span>收起</span>&nbsp;<i class="iconfont">&#xe60f;</i></p>
            </div>
        </div>
        <!--酒店政策-->
        <div class="info-main-description-box">
            <h2 class="info-main-description-box-title">酒店政策</h2>
            <ul class="hotel-policy">
                <li v-for="item in infoList">
                    <!--h3>酒店提示</h3-->
                    <p v-text="item"></p>
                </li>
            </ul>
            <div class="show-more">
                <p class="tab-show" v-show="!isAllInfo" @click="showInfo(1)"><span>展开全部</span>&nbsp;<i class="iconfont">&#xe610;</i></p>
                <p class="tab-show" v-show="isAllInfo" data-type="length" @click="showInfo(0)"><span>收起</span>&nbsp;<i class="iconfont">&#xe60f;</i></p>
            </div>
        </div>
        <div><img style="width: 100%" src="/public/hotel/images/bottom-img.png"></div>
    </div>
    <script src="/public/hotel/js/jquery.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/swiper-3.3.1.jquery.min.js"></script>
    <script src="/public/hotel/js/info_description.js"></script>
</body>
</html>
