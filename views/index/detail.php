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
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/hotel-common.css" />
    <link rel="stylesheet" href="/css/info.css" />
    <link rel="stylesheet" href="/css/calendar.css"/>
    <style type="text/css">
        /* .mask_calendar {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,.4);
            display: none;
        }
        .calendar {
            height: 400px;
            position: fixed;
            bottom: 0;
            left: 0;
        } */
        .Date_lr {
            width: 50%;
            text-align: center;
        }

        .span21 {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            font-size: 14px;
            color: #666;
            border: 1px solid #e5e5e5;
            padding: 2px 8px;
            line-height: 20px;
            border-radius: .2rem;
            background-color: #fff;
        }

        #checkinout {
            height: 50px;
            line-height: 50px;
            position: relative;
            margin: 10px;
            padding: 2px 0;
            display: -webkit-box;
            display: flex;
            border: 1px solid #e5e5e5;
            border-radius: .02rem;
            background-color: #fff;
        }

        #firstSelect p {
            line-height: 25px;
            color: #999;
            font-size: 12px;
        }

        #startDate {
            border: 0;
            position: absolute;
            left: 0;
            margin: 0 auto;
            width: 50%;
            font-size: 16px;
            color: #4189ff;
            text-align: center;
        }

        #endDate {
            border: 0;
            position: absolute;
            right: 0;
            margin: auto 0;
            width: 50%;
            font-size: 16px;
            color: #4189ff;
            text-align: center;
        }

        .mask_calendar {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, .4);
            display: none;
            z-index: 9999;
        }

        .calendar {
            height: 400px;
            position: fixed;
            bottom: 0;
            left: 0;
        }

        .animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        @keyframes slideInDown {
            from {
                transform: translate3d(0, -100%, 0);
                visibility: visible;
            }

            to {
                transform: translate3d(0, 0, 0);
            }
        }

        .slideInDown {
            animation-name: slideInDown;
        }
    </style>
    <link id="js_maincss" rel="Stylesheet" type="text/css" href="/css/n_main.css">
    <link rel="stylesheet" href="/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/css/ion.rangeSlider.skinHTML5.css">
    <link rel="stylesheet" href="/css/mobiscroll.css">
    <link rel="stylesheet" href="/css/photoswipe.css">
    <link rel="stylesheet" href="/css/photoswipe-default-skin.css">
    <link rel="stylesheet" href="/css/league_style.css">
    <link rel="stylesheet" href="/css/group.css">
    <link rel="stylesheet" href="/css/activity.css">

    <link rel="stylesheet" href="/css/calendar.css">
</head>
<body>
    <div  id="app">
    <div id="main-box" >
    <div class="info-main">
        <p class="goBack"><a style="color: #fff;" href="javascript:;"><i class="iconfont f20">&#xe605;</i></a></p>
        <!--banner-->
        <div class="info-main-banner" style="min-height: 220px;">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" ><img src="<?= $hotel_info['img'] ?>" style="width:100%;height:220px;"></div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="banner-title">
                <div class="mt-detail-title"><h1 class="ellips"><?= $hotel_info['hotel_name'] ?></h1><i
                        class="h_icons_diamond11 h_icons"></i></div>
<!--                <ul>-->
<!--                    <li class="left">--><?//= $hotel_info['hotel_name'] ?><!--<i class="h_icons_diamond11 h_icons"></i></li>-->
<!--                </ul>-->
            </div>
        </div>
        <div class="mt-detail-list page__detail--wrap">
            <div class="mt-details" style="display:block">
                <ul class="mt-detail-top g-detail-top">
                    <li data-hotelid="419612" data-jumphotel="more">
                        <div class="mt-place-left mt-hotel-icon"><span>
                    <?= $hotel_info['find_time'] ?>年开业
                      </span><span class="c9d f22" name="hotel-level">高档型</span></div>
                    </li>
                    <li data-hotelid="419612" data-jumphotel="map">
                        <div class="mt-place-left"><p class="f24"><span
                                    class="adr__txt--loc area-txt"><?= $hotel_info['hotel_address'] ?></span>
                            </p>
                            <p class="c9d f22">距展馆 562m</p></div>
                        <div class="mt-place-right"><span class="mt-detail-more">地图</span></div>
                    </li>
                </ul>
            </div>
        <!--banner-end-->

        <!--date-->
        <div id="checkinout">
            <div id="firstSelect" style="width:100%;">
                <div class="Date_lr" style="float:left;">
                    <P>入住</p>
                    <input id="startDate" type="text" value="" style="" readonly>
                </div>
                <div class="Date_lr" style="float:right;">
                    <p>离店</p>
                    <input id="endDate" type="text" value="" style="" readonly>
                </div>
                <span class="span21">共<span class="NumDate">1</span>晚</span>
            </div>
        </div>
        <div class="mask_calendar">
            <div class="calendar"></div>
        </div>

        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/date.js"></script>
        <script>
            $(function () {
                $('#firstSelect').on('click', function () {
                    $('.mask_calendar').show();
                });
                $('.mask_calendar').on('click', function (e) {
                    if (e.target.className == "mask_calendar") {
                        $('.calendar').slideUp(200);
                        $('.mask_calendar').fadeOut(200);
                    }
                })
                $('#firstSelect').calendarSwitch({
                    selectors: {
                        sections: ".calendar"
                    },
                    index: 4,      //展示的月份个数
                    animateFunction: "slideToggle",        //动画效果
                    controlDay: true,//知否控制在daysnumber天之内，这个数值的设置前提是总显示天数大于90天
                    daysnumber: "90",     //控制天数
                    comeColor: "#2EB6A8",       //入住颜色
                    outColor: "#2EB6A8",      //离店颜色
                    comeoutColor: "#E0F4F2",        //入住和离店之间的颜色
                    callback: function () {//回调函数
                        $('.mask_calendar').fadeOut(200);
                        var startDate = $('#startDate').val();  //入住的天数
                        var endDate = $('#endDate').val();      //离店的天数
                        var NumDate = $('.NumDate').text();    //共多少晚
                        console.log(startDate);
                        console.log(endDate);
                        console.log(NumDate);
                        //下面做ajax请求
                        //show_loading();
                        /*$.post("demo.php",{startDate:startDate, endDate:endDate, NumDate:NumDate},function(data){
                         if(data.result==1){
                         //成功
                         } else {
                         //失败
                         }
                         });*/
                    },
                    comfireBtn: '.comfire'//确定按钮的class或者id
                });
                var b = new Date();
                var ye = b.getFullYear();
                var mo = b.getMonth() + 1;
                mo = mo < 10 ? "0" + mo : mo;
                var da = b.getDate();
                da = da < 10 ? "0" + da : da;
                $('#startDate').val(ye + '-' + mo + '-' + da);
                b = new Date(b.getTime() + 24 * 3600 * 1000);
                var ye = b.getFullYear();
                var mo = b.getMonth() + 1;
                mo = mo < 10 ? "0" + mo : mo;
                var da = b.getDate();
                da = da < 10 ? "0" + da : da;
                $('#endDate').val(ye + '-' + mo + '-' + da);
            });
        </script>
        <!--date-->
        <div class="info-room-list">
            <div class="detail-mt">
                <?php foreach ($detail as $key => $value) { ?>
                    <ul class="mt-detail-info bor-btm g-details-list js_roomlist_ul"
                        name="room_list_data">
                        <li class="mt-cell-list <?= ($key == 0) ? 'inactives' : '' ?> "
                            data-origin-ind="0">
                            <div class="detail_room_box js-base-layer">
                                <img src="<?= $value['img'] ?>">
                            </div>
                            <div class="g-r-info js-openlist">
                                <div class="fx1">
                                    <p class="">
                                                            <span class="g-title">
                                                                <?= $value['room_name'] ?>
                                                            </span>
                                    </p>
                                    <p class="">
                                                            <span class="c99">
                                                                面积&nbsp;<?= $value['area'] ?>㎡&nbsp;
                                                            </span>
                                    </p>
                                    <span class="g-pri-dw" >
                                                            <span class="g-pri"  style="float: right;
    margin-right: 10px;">
                                                                <dfn>¥&nbsp;<em><?= $value['min_price'] ?></em></dfn>&nbsp;起
                                                            </span>
                                                        </span>
                                    <i class="demand_tab"></i>
                                </div>
                            </div>
                        </li>
                        <ol class="demand_expand_box  g-detail-show cont__ut--unfold" style="<?= ($key == 0) ? 'display: block' : 'display: none' ?>">
                            <?php foreach ($value['bed_list'] as $bed) { ?>
                                <li class="demand_expand_box_li">
                                    <div class="grid__dem--left fx1">
                                        <div class="txt__el--up">
                                            <em class="spec-pri">专享价</em>
                                        </div>
                                        <div class="txt__el--down">
                                            <?= $bed['bed_name'] ?>/<?= $bed['breakfast'] ?>
                                        </div>
                                    </div>
                                    <div class="gri__el--pri df a-i-c fx1 lh">
                                        <div class="demand_expand_info"><p>
                                                                    <span class="pri__el--spec" style="float: right;
    margin-right: 10px;">
                                                                        <span class="g-pri">
                                                                            <dfn>¥<em><?= $bed['price'] ?></em></dfn>
                                                                        </span>
                                                                    </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="demand_left_box">
                                        <button class="demand_btn js-li-book"
                                                data-bedId="<?= $bed['id'] ?>">预订
                                        </button>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--con-pop-->
    <div class="mask" style="display: none;" v-show="isMask"></div>
    <div class="hotel-con-data" :class="{'hotel-con-data-enter':room_info}">
        <ul class="pop-box" style="margin-bottom: 10px;">
            <li class="title"><b>RoomName</b><i class="iconfont close-pop">&#xe612;</i></li>
            <li class="con-list">
                <p><span>面积：</span>AreaRange平方米</p>
                <p><span>楼层：</span>FloorRange</p>
                <p><span>床型：</span>bedInfo</p>
                <p><span>窗户：</span>HasWindow</p>
                <!--p><span>加床：</span>{{info_pop_obj.AreaRange}}</p-->
                <p><span>无烟：</span>NotAllowSmoking</p>
                <p><span>网络：</span>BroadNetInfo</p>
                <p><span>早餐：</span>Breakfast</p>
            </li>
        </ul>
        <ul class="pop-box-price">
            <li class="left"><p class="price">总价：<i>¥</i><span>AveragePrice</span></p><p class="date">共{{gap_day}}晚</p></li>
            <li class="right"><a>立即预定</a></li>
        </ul>
    </div>
    <!--con-pop-end-->
    </div>
    </div>
    <!-- 如果使用了某些拓展插件还需要额外的JS -->
</body>
<script>
$('.demand_btn').click(function(){
var hotelId = <?=$_GET['hotelId']?>;
var bedId = $(this).attr('data-bedId');

var startDate = $('#startDate').val();
var endDate = $('#endDate').val();
window.location.href='/index/pay?startDate='
+startDate+
'&endDate='+endDate+
'&hotelId='+hotelId+
'&bedId='+bedId;
})
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.mt-cell-list').click(function () {

            $(this).parent('ul').siblings('li').removeClass('inactives');
            $(this).addClass('inactives');
//            $(this).siblings('ul').slideDown(100).children('li');
            if ($(this).parents('ul').children('ol').css('display') == 'block') {
                $(this).parents('ul').children('li').removeClass('inactives');
//                $(this).parents('li').siblings('li').children('ul').slideUp(100);
                $(this).parents('ul').children('ol').css('display', 'none');
            } else {
                $(this).parents('ul').children('li').addClass('inactives');
//                $(this).parents('li').siblings('li').children('ul').slideUp(100);
                $(this).parents('ul').children('ol').css('display', 'block');
            }

        })
    });
</script>
</html>
