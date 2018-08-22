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
    <title>酒店详情_会唐网</title>
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/info.css" />
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div  id="app">
    <div id="main-box" style="display: none;">
    <div class="info-main">
        <p class="goBack" :class="{'top20':platform == 'ios'}"><a style="color: #fff;" href="javascript:;" @click="goBack"><i class="iconfont f20">&#xe605;</i></a></p>
        <!--banner-->
        <div class="info-main-banner" style="min-height: 220px;">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="item in hotelInfo.pics"><img :src="item.pic_url" style="width:100%;height:220px;"></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="banner-title">
                <ul>
                    <li class="left">{{hotelInfo.place_name}}<span>【{{hotelInfo.star_rate}}】</span></li>
                    <li class="right"><span class="swiper-count">1/1</span><i class="iconfont">&#xe60d;</i></li>
                </ul>
            </div>
        </div>
        <!--banner-end-->
        <!--map-->
        <div class="info-map">
            <div class="map-left"><i class="iconfont">&#xe6eb;</i></div>
            <div class="map-center">
                <p class="name">{{hotelInfo.address}}</p>
                <p class="location">{{hotelInfo.jl}}</p>
            </div>
            <a style="position: absolute;right: 0;top: 0;width: 90px;height: 70px;z-index: 100;" :href="'/hotel/map?location='+hotel_location+'&hotelName='+hotelInfo.place_name+'&address='+hotelInfo.address"></a>
            <div class="map-right" id="allmap"></div>

        </div>
        <!--map-end-->
        <!--date-->
        <div class="info-date">
            <table>
                <tr>
                    <td>
                        <p>入住</p>
                        <div>
                            <span>{{start_cn}}</span>{{start_week}}
                            <input id="date-start" type="text" readonly="readonly" value="" class="hidden_input">
                        </div>
                    </td>
                    <td><span class="count">共{{gap_day}}晚</span></td>
                    <td>
                        <p>离店</p>
                        <div>
                            <span>{{end_cn}}</span>{{end_week}}
                            <input id="date-end" type="text" readonly="readonly" value="" class="hidden_input">
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!--date-->
        <div class="info-room-list">
            <table v-if="roomList.length" class="outer-table" cellspacing="0" cellpadding="0" border="0">
                <tr class="bg" :class="{'table-disabled':!item.IsCanReserve}" v-for="item in roomList" :class="{'table-disabled':item.RoomInfo.length == 0}">
                    <td class="box">
                        <table class="head-table" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td  @click="show_pop_img(item)" class="img" style="width: 78px;"><p class="show-img-pop"><img :src="item.pics[0]" style="width:78px;height:78px;"></p></td>
                                <td class="con" align="left">
                                    <div class="title show-pop" v-text="item.RoomName"></div>
                                    <div class="info"><span>{{item.AreaRange}}㎡</span><span>{{item.FloorRange}}层</span><span class="end">{{item.RoomInfo[0].BroadNetInfo}}</span></div>
                                    <div class="sm"><span>{{item.HasWindow}}</span>&nbsp;&nbsp;<span>最多可住{{item.Person}}人</span></div>
                                </td>
                                <td class="price" align="center">
                                    <p class="num">¥<span>{{item.minPrice}}</span><span class="ccc">起</span><i v-show="!item.isShown" @click="item.isShown = !item.isShown" class="iconfont show-inner">&#xe688;</i><i v-show="item.isShown" @click="item.isShown = !item.isShown" class="iconfont hide-inner">&#xe671;</i></p>
                                    <img v-if="item.RoomInfo.length == 0" class="style-end" src="/public/hotel/images/end.png">
                                    <img v-show="!item.IsCanReserve" class="style-end" src="/public/hotel/images/end.png">
                                </td>
                            </tr>
                        </table>
                        <table class="inner-table" v-show="item.isShown" v-if="item.RoomInfo.length">
                            <tr v-for="items in item.littleRooms">
                                <td @click="show_room_info(item,items)">
                                    <p class="inner-title" v-text="items.RoomName"></p>
                                    <p class="inner-con1"><span>{{items.bedType}}</span><span :class="{'warn3':items.Breakfast.indexOf('无')==-1}">{{items.Breakfast}}</span><span>可住{{items.Person}}人</span><span  :class="{'warn3':items.BroadNetInfo.indexOf('免费')!=-1}">{{items.BroadNetInfo}}</span></p>
                                    <p class="inner-con2">
                                        <span :class="{'warn1':items.pay_type==1}">{{items.pay_type==1?'在线付':'到店付'}}</span><span :class="{'warn3':items.policyType=='免费取消'}">{{items.policyType}}</span>
                                    </p>
                                </td>
                                <td v-if="!items.IsCanReserve" class="price" align="center">
                                    <p class="num">¥<span>{{items.AveragePrice}}</span></p>
                                    <p><a href="javascript:;" class="info-btn-disabled">已订完</a></p>
                                    <img class="style-end" src="/public/hotel/images/end.png">
                                </td>
                                <td v-if="items.IsCanReserve" class="price" align="center">
                                    <p class="num">¥<span>{{items.AveragePrice}}</span></p>
                                    <p><a :href="'/hotel/pay?hotel_id='+hotel_id+'&cur_location='+cur_location+'&hotel_name='+hotelInfo.place_name+'&city_id='+hotelInfo.city_id+'&city_name='+hotelInfo.city_name+'&room_id='+items.RoomID+'&room_name='+items.RoomName+'&ctrip_id='+ctrip_id+'&ArrivalDate='+start_date+'&DepartureDate='+end_date+'&gap_day='+gap_day+'&hotel_address='+hotelInfo.address+'&breakfast='+items.Breakfast+'&roomName='+item.RoomName+'&bedInfo='+items.bedInfo+'&price='+items.AveragePrice+'&pay_type='+items.pay_type+'&policyType='+items.policyType+'&RatePlanCategory='+items.RatePlanCategory" class="info-btn">预订</a></p>
                                </td>
                            </tr>
                            <tr v-if="item.RoomInfo.length>3">
                                <td colspan="2" align="center" class="button">
                                    <p class="show-some" v-show="item.littleRooms.length>3" @click="showRooms(item,3)">收起&nbsp;<i class="iconfont">&#xe60f;</i></p>
                                    <p class="show-all" v-show="item.littleRooms.length<=3" @click="showRooms(item)">查看全部&nbsp;<i class="iconfont">&#xe610;</i></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div v-else style="text-align: center;padding: 10px 0;">
                <p><img src="/public/hotel/images/no-list.png" style="width: 90px;"></p>
                <p style="color: #666;padding-top: 10px;">该酒店暂无房间信息，请重新选择。</p>
            </div>
        </div>
        <div class="info-device">
            <table>
                <tr>
                    <td><p><i class="iconfont">&#xe64a;</i></p><p>吹风机</p></td>
                    <td><p><i class="iconfont">&#xe661;</i></p><p>全天热水</p></td>
                    <td><p><i class="iconfont">&#xe655;</i></p><p>行李寄存</p></td>
                    <td><p><i class="iconfont">&#xe65b;</i></p><p>包含停车</p></td>
                    <td><p><i class="iconfont">&#xe63f;</i></p><p>空调</p></td>
                    <td><a :href="'/hotel/info_description?h_id='+hotel_id+'&location='+cur_location" style="text-decoration: none;"><p class="info">详情<i class="iconfont">&#xe613;</i></p></a></td>
                </tr>
            </table>
        </div>
        <div class="info-room-hot">
            <ul class="title">
                <li class="line"></li>
                <li class="text">推荐参考</li>
            </ul>
            <ul class="list-box">
                <li class="style" v-for="item in mapHotel">
                    <a :href="'/hotel/info?h_id='+item.place_id+'&c_id='+item.ctrip_id+'&city_location='+city_location+'&start_date='+start_date+'&end_date='+end_date+'&cur_location='+cur_location">
                    <p class="img"><img :src="item.main_pic_url" ></p>
                    <p class="text-title" v-text="item.place_name"></p>
                    <p class="price"><i>¥</i>{{item.roomMinPrice}}<span>起</span></p>
                    </a>
                </li>
            </ul>
        </div>
        <div><img style="width: 100%" src="/public/hotel/images/bottom-img.png"></div>
    </div>
    <!--con-pop-->
    <div class="mask" style="display: none;" v-show="isMask"></div>
    <div class="hotel-con-data" :class="{'hotel-con-data-enter':room_info}">
        <ul class="pop-box" style="margin-bottom: 10px;">
            <li class="title"><b>{{info_pop_obj.RoomName}}</b><i @click="hide_room_info" class="iconfont close-pop">&#xe612;</i></li>
            <li class="con-list">
                <p><span>面积：</span>{{info_pop_obj.AreaRange}}平方米</p>
                <p><span>楼层：</span>{{info_pop_obj.FloorRange}}</p>
                <p><span>床型：</span>{{info_pop_obj.bedInfo}}</p>
                <p><span>窗户：</span>{{info_pop_obj.HasWindow}}</p>
                <!--p><span>加床：</span>{{info_pop_obj.AreaRange}}</p-->
                <p><span>无烟：</span>{{info_pop_obj.NotAllowSmoking}}</p>
                <p><span>网络：</span>{{info_pop_obj.BroadNetInfo}}</p>
                <p><span>早餐：</span>{{info_pop_obj.Breakfast}}</p>
            </li>
        </ul>
        <ul class="pop-box">
            <li class="title"><b>退房政策</b></li>
            <li class="hotel-desc">
                <p class="left"><span>{{info_pop_obj.policyType}}</span></p>
                <p class="right">{{info_pop_obj.policyText}}</p>
            </li>
        </ul>
        <ul class="pop-box-price">
            <li class="left"><p class="price">总价：<i>¥</i><span>{{gap_day*info_pop_obj.AveragePrice}}</span></p><p class="date">共{{gap_day}}晚</p></li>
            <li v-if="info_pop_obj.IsCanReserve" class="right"><a :href="'/hotel/pay?hotel_id='+hotel_id+'&cur_location='+cur_location+'&hotel_name='+hotelInfo.place_name+'&city_id='+hotelInfo.city_id+'&city_name='+hotelInfo.city_name+'&room_id='+info_pop_obj.RoomID+'&room_name='+info_pop_obj.RoomName+'&ctrip_id='+ctrip_id+'&ArrivalDate='+start_date+'&DepartureDate='+end_date+'&gap_day='+gap_day+'&hotel_address='+hotelInfo.address+'&breakfast='+info_pop_obj.Breakfast+'&roomName='+info_pop_obj.outRoomName+'&bedInfo='+info_pop_obj.bedInfo+'&price='+info_pop_obj.AveragePrice+'&pay_type='+info_pop_obj.pay_type+'&policyType='+info_pop_obj.policyType+'&RatePlanCategory='+info_pop_obj.RatePlanCategory">立即预定</a></li>
            <li v-if="!info_pop_obj.IsCanReserve" class="right" style="background: #ccc;"><a href="javascript:;">已订完</a></li>
        </ul>
    </div>
    <div class="hotel-img-data" v-show="pop_img" id="hotel-img-data">
        <h2>{{img_pop_obj.name}}</h2>
        <div class="pop-banner">
            <div class="swiper-container1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" v-for="items in img_pop_obj.pics"><img :src="items" style="width:100%;height:300px;"></div>
                </div>
                <div class="swiper-pagination1"></div>
            </div>
            <span class="swiper-count1">1/12</span>
        </div>
        <div class="pop-room-info">
            <h3>房型信息</h3>
            <ul>
                <li><i class="iconfont">&#xe697;</i>{{img_pop_obj.AreaRange}}平方米</li>
                <li><i class="iconfont">&#xe68e;</i>楼层{{img_pop_obj.FloorRange}}层</li>
                <li><i class="iconfont">&#xe68f;</i>入住{{img_pop_obj.Person}}人</li>
                <li><i class="iconfont">&#xe696;</i>{{img_pop_obj.NotAllowSmoking}}</li>
                <li><i class="iconfont">&#xe690;</i>{{img_pop_obj.bedInfo}}</li>
            </ul>
            <p class="hide-show-img" @click="hide_pop_img">查看更多房间信息</p>
        </div>
    </div>
    <!--con-pop-end-->
    </div>
    </div>
    <div id="global_login"></div>
    <script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8&services=&t=20170823191629"></script>
    <script src="/eventown/js/zepto.min.js"></script>
    <script src="/public/hotel/js/jquery-weui.js"></script>
    <script src="/public/hotel/js/city-picker.js"></script>
    <script src="/public/hotel/js/moment.min.js"></script>
    <script src="/public/hotel/js/swiper-3.3.1.jquery.min.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script src="/public/hotel/js/info.js"></script>
    <!-- 如果使用了某些拓展插件还需要额外的JS -->
</body>
</html>
