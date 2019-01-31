<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- 是否启动webapp功能，会删除默认的苹果工具栏和菜单栏。 -->
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <!-- 当启动webapp功能时，显示手机信号、时间、电池的顶部导航栏的颜色。默认值为default（白色），可以定为black（黑色）和black-translucent（灰色半透明）。这个主要是根据实际的页面设计的主体色为搭配来进行设置。 -->
    <meta name="format-detection" content="telephone=no, email=no" />
    <title><?= $hotel_info['hotel_name'] ?>_酒店详情</title>
    <link rel="stylesheet" href="/css/base.css" />
    <link rel="stylesheet" href="/css/hotel-common.css" />
    <link rel="stylesheet" href="/css/info.css" />
    <link rel="stylesheet" href="/css/calendar.css"/>
    <link rel="stylesheet" href="/css/index-date.css"/>
    <script src="/js/jquery-1.8.2.js"></script>
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        input{
            border:none;
            width: 200px;
        }
        #RangeDate{
            z-index:2;
            display: flex;
            flex-wrap: wrap;
            text-align: center;
            font-size: 14px;
            line-height: 50px;
            color: #333;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            background: white;
        }
        .RangeDate_xinqi{
            width: 14%;
            height: 40px;
            line-height: 40px;
            color: #666;
        }
        .RangeDate_title{
            height: 36px;
            line-height: 36px;
            font-size: 14px;
            color: #333;
            background: #fafafa;
            width: 100%;
            border-bottom: 1px solid #eee;
            border-top: 1px solid #eee;
        }
        .RangeDate_day{
            height: 48px;
            width: 14%;
            position: relative;
            margin:1px 0;
        }
        .RangeDate_day:before{
            content: '';
            display: none;
            position: absolute;
            color: #fff;
            width: 0;
            height: 0;
            top: -6px;
            left: 30px;
            border-left: 3px solid transparent;
            border-right: 3px solid transparent;
            border-top: 6px solid rgba(0,0,0,0.7);
        }
        .RangeDate_promptSmall{
            position: absolute;
            top: -26px;
            left: 5%;
            background: rgba(0,0,0,0.7);
            border-radius: 2px;
            color: #FFF;
            padding: 0 6px;
            line-height: 20px;
            font-size: 12px;
            white-space: nowrap;
        }
        .RangeDate_promptBig{
            position: absolute;
            top: -26px;
            left: -40%;
            background: rgba(0,0,0,0.7);
            border-radius: 2px;
            color: #FFF;
            padding: 0 6px;
            line-height: 20px;
            font-size: 12px;
            white-space: nowrap;
        }
        .RangeDate_promptBigLeft{
            position: absolute;
            top: -26px;
            left: 0;
            background: rgba(0,0,0,0.7);
            border-radius: 2px;
            color: #FFF;
            padding: 0 6px;
            line-height: 20px;
            font-size: 12px;
            white-space: nowrap;
        }
        .RangeDate_promptBigRight{
            position: absolute;
            top: -26px;
            right: 0;
            background: rgba(0,0,0,0.7);
            border-radius: 2px;
            color: #FFF;
            padding: 0 6px;
            line-height: 20px;
            font-size: 12px;
            white-space: nowrap;
        }
        .RangeDate_dayShow:before{
            display: block;
        }
        .RangeDate_dayStart:after{
            content: '入住';
            display: block;
        }
        .RangeDate_dayEnd:after{
            content: '离店';
            display: block;
        }
        .RangeDate_dayStart{
            line-height: 24px;
            background: #2db6a6;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
            color: #fff;
        }
        .RangeDate_dayCenter{
            background: #dff3f1;
        }
        .RangeDate_dayEnd{
            line-height: 24px;
            background: #2db6a6;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            color: #fff;
        }
        .RangeDate_A1{
            color: #a1a1a1;
        }
        .RangeDate_dayNo{
            color:#a2a2a2;
        }
        .RangeDate_week{
            color: #f9957b;
        }
        .RangeDate_head{
            width: 100%;
            box-sizing: border-box;
            text-align: left;
            color: #666;
            font-size: 16px;
            padding-left: 20px;
            border-bottom: 1px solid #eee;
        }
        .RangeDate_done{
            color: #27b4a4;
            float: right;
            height: 30px;
            line-height: 30px;
            border-radius: 4px;
            border: 1px solid #27b4a4;
            margin: 10px 20px;
            padding:0 10px;
        }
        #RangeDate_container{
            display: flex;
            align-items: center;
            width: 100%;
            height:300px;
            overflow-y: scroll;
            overflow-x: hidden;
            flex-wrap: wrap;
        }
        .RangeDate_none{
            display: none !important;
        }
    </style>
    <style type="text/css">
        .time{
            color: #4189ff;
            font-size: 16px;
            text-align: center;
        }
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
            border-radius: .8rem;
            background-color: #fff;
        }

        #checkinout {
            height: 50px;
            /*line-height: 50px;*/
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
            width: 40%;
            font-size: 16px;
            color: #4189ff;
            text-align: center;
        }

        #endDate {
            border: 0;
            position: absolute;
            right: 0;
            margin: auto 0;
            width: 40%;
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
                <div class="mt-detail-title">
                    <h1 class="ellips"><?= $hotel_info['hotel_name'] ?></h1>
<!--                    <span style="font-size:10px">(2月23日～3月2日)</span>-->
                    <i class="h_icons_diamond5 h_icons"></i>
                </div>
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
                            <p class="c9d f22"><?= $hotel_info['distances'] ?></p></div>
<!--                        <div class="mt-place-right"><span class="mt-detail-more">地图</span></div>-->
                    </li>
                </ul>
            </div>
        <!--banner-end-->

        <!--date-->
        <div id="checkinout" class="row select-time">
            <div id="firstSelect" style="width:100%;">
                <div class="Date_lr" style="float:left;">
                    <P>入住</p>
                    <span class="time entertime"><?=$_GET['startDate']?></span>
                    <input id="startDate" class="input-enter none" type="text" value="<?=$_GET['startDate']?>" style="" readonly>
                </div>
                <div class="Date_lr" style="float:right;">
                    <p>离店</p>
                    <span class="time leavetime"><?=$_GET['endDate']?></span>
                    <input id="endDate" class="input-leave none" type="text" value="<?=$_GET['endDate']?>" style="" readonly>
                </div>
                <span class="span21 night">共<span class="NumDate">1</span>晚</span>
            </div>
        </div>

        <div class="mask_calendar">
            <div class="calendar"></div>
        </div>

        <script type="text/javascript" src="/js/jquery.min.js"></script>
<!--            <script type="text/javascript" src="/js/date2.js"></script>-->
            <script type="text/javascript">
                window.RangeDate=function(RangeDateID){
                    $('body').append(
                        '<div id="RangeDate" class="RangeDate_none">'+
                        '<div class="RangeDate_head">'+
                        '请选择入离日期'+
                        '<div class="RangeDate_done">'+
                        '完成'+
                        '</div>'+
                        '</div>'+
                        '<div class="RangeDate_xinqi RangeDate_week">日</div>'+
                        '<div class="RangeDate_xinqi">一</div>'+
                        '<div class="RangeDate_xinqi">二</div>'+
                        '<div class="RangeDate_xinqi">三</div>'+
                        '<div class="RangeDate_xinqi">四</div>'+
                        '<div class="RangeDate_xinqi">五</div>'+
                        '<div class="RangeDate_xinqi RangeDate_week">六</div>'+
                        '<div id="RangeDate_container"></div>'+
                        '</div>'
                    )



                    var today=new Date();
                    var fu=document.querySelector('#RangeDate_container');
                    var startWeek=new Date(today.getFullYear(),today.getMonth(),1). getDay();
                    var dayNum=32-(new Date(today.getFullYear(),today.getMonth(),32).getDate());
                    var monthNum= 0,flag= 1,RangeDate_start=true,RangeDate_end=true,RangeDate_startId='',RangeDate_endId='',RangeDate_center=[];
                    var prompt=document.createElement('div');
                    $(prompt).addClass('RangeDate_prompt')

                    function getDay(attr){
                        var monthTitle=document.createElement('div');
                        $(monthTitle).addClass('RangeDate_title');
                        monthTitle.innerHTML=new Date(today.getFullYear(),today.getMonth()+monthNum,1).getFullYear()+'年'+(new Date(today.getFullYear(),today.getMonth()+monthNum,1).getMonth()+1)+'月';
                        fu.appendChild(monthTitle);
                        var firstDay=document.createElement('div');
                        $(firstDay).addClass('RangeDate_day');
                        $(firstDay).attr('id','RangeDate_'+flag);
                        $(firstDay).attr('data-id',attr+'1');
                        flag++;
                        firstDay.style.marginLeft=startWeek*14+"%";
                        firstDay.style.width='14%';
                        firstDay.innerHTML='1';
                        firstDay.onclick=function(){
                            RangeDateClick(this);
                        }
                        fu.appendChild(firstDay);
                        for(var i=2;i<=dayNum;i++){
                            var j=document.createElement('div');
                            $(j).addClass('RangeDate_day');
                            $(j).attr('id','RangeDate_'+flag);
                            flag++;
                            j.innerHTML=i+'';
                            $(j).attr('data-id',attr+i);
                            j.onclick=function(){
                                RangeDateClick(this);
                            }
                            fu.appendChild(j)
                        }
                        monthNum++;
                        startWeek=new Date(today.getFullYear(),today.getMonth()+monthNum,1).getDay();
                        dayNum=32-(new Date(today.getFullYear(),today.getMonth()+monthNum,32).getDate());
                    }

                    function RangeDateClick(ele){
                        console.log($('#RangeDate_container').width()-$(ele).offset().left-$(ele).width())
                        if(RangeDate_start){
                            $(ele).addClass('RangeDate_dayStart');
                            $(ele).addClass('RangeDate_dayShow');
                            RangeDate_start=false;
                            RangeDate_startId=$(ele).attr('id');
                            $(prompt).removeClass();
                            if($(ele).offset().left<=10){
                                $(prompt).addClass('RangeDate_promptBigLeft')
                            }else if($('#RangeDate_container').width()-$(ele).offset().left-$(ele).width()<=10){
                                $(prompt).addClass('RangeDate_promptBigRight')
                            }else {
                                $(prompt).addClass('RangeDate_promptBig')
                            }
                            $(ele)[0].appendChild(prompt);
                            prompt.innerHTML='请选择离店时间';
                            return;
                        }
                        if(RangeDate_end){
                            if($(ele).attr('id').split('_')[1]*1>$('#'+RangeDate_startId).attr('id').split('_')[1]*1){
                                $(prompt).removeClass();
                                $('#'+RangeDate_startId).removeClass('RangeDate_dayShow');
                                $(ele).addClass('RangeDate_dayEnd');
                                RangeDate_end=false;
                                RangeDate_endId=$(ele).attr('id');
                                $('#'+RangeDate_endId).addClass('RangeDate_dayShow');
                                $(prompt).addClass('RangeDate_promptSmall');
                                $('#'+RangeDate_endId)[0].appendChild(prompt);
                                prompt.innerHTML='共 '+(RangeDate_endId.split('_')[1]-RangeDate_startId.split('_')[1])+' 晚';
                            }else if($(ele).attr('id').split('_')[1]<$('#'+RangeDate_startId).attr('id').split('_')[1]){
                                $(prompt).removeClass();
                                $('#'+RangeDate_startId).removeClass('RangeDate_dayShow');
                                $('#'+RangeDate_startId).removeClass('RangeDate_dayStart');
                                $('#'+RangeDate_startId).addClass('RangeDate_dayEnd');
                                RangeDate_endId=$('#'+RangeDate_startId).attr('id');
                                $(ele).addClass('RangeDate_dayStart');
                                RangeDate_startId=$(ele).attr('id');
                                $('#'+RangeDate_endId).addClass('RangeDate_dayShow');
                                $(prompt).addClass('RangeDate_promptSmall');
                                $('#'+RangeDate_endId)[0].appendChild(prompt);
                                prompt.innerHTML='共 '+(RangeDate_endId.split('_')[1]-RangeDate_startId.split('_')[1])+' 晚';
                                RangeDate_end=false;
                            }else {
                                return;
                            }
                            if(RangeDate_center.length>0){
                                for(var i=0;i<RangeDate_center.length;i++){
                                    $('#RangeDate_'+RangeDate_center[i]).removeClass('RangeDate_dayCenter');
                                }
                                RangeDate_center=[];
                            }
                            for(var i=RangeDate_startId.split('_')[1]*1+1;i<RangeDate_endId.split('_')[1]*1;i++){
                                $('#RangeDate_'+i).addClass('RangeDate_dayCenter');
                                RangeDate_center.push(i)
                            }
                            return;
                        }
                        if(!RangeDate_start && !RangeDate_end){
                            $('#'+RangeDate_startId).removeClass('RangeDate_dayStart');
                            $('#'+RangeDate_endId).removeClass('RangeDate_dayEnd');
                            $('#'+RangeDate_endId).removeClass('RangeDate_dayShow');
                            $('#'+RangeDate_endId)[0].removeChild(prompt);
                            $(ele).addClass('RangeDate_dayStart');
                            $(ele).addClass('RangeDate_dayShow');
                            $(prompt).removeClass();
                            if($(ele).offset().left<=10){
                                $(prompt).addClass('RangeDate_promptBigLeft')
                            }else if($('#RangeDate_container').width()-$(ele).offset().left-$(ele).width()<=10){
                                $(prompt).addClass('RangeDate_promptBigRight')
                            }else {
                                $(prompt).addClass('RangeDate_promptBig')
                            }
                            $(ele)[0].appendChild(prompt);
                            prompt.innerHTML='请选择离店时间';
                            RangeDate_startId=$(ele).attr('id');
                            RangeDate_end=true;
                            if(RangeDate_center.length>0){
                                for(var i=0;i<RangeDate_center.length;i++){
                                    $('#RangeDate_'+RangeDate_center[i]).removeClass('RangeDate_dayCenter');
                                }
                                RangeDate_center=[];
                            }
                        }
                    }
                    getDay(new Date(today.getFullYear(),today.getMonth()+1,1).getFullYear()+'-'+new Date(today.getFullYear(),today.getMonth()+1,1).getMonth()+'-');
                    getDay(new Date(today.getFullYear(),today.getMonth()+2,1).getFullYear()+'-'+new Date(today.getFullYear(),today.getMonth()+2,1).getMonth()+'-');
                    getDay(new Date(today.getFullYear(),today.getMonth()+3,1).getFullYear()+'-'+new Date(today.getFullYear(),today.getMonth()+3,1).getMonth()+'-');
                    getDay(new Date(today.getFullYear(),today.getMonth()+4,1).getFullYear()+'-'+new Date(today.getFullYear(),today.getMonth()+4,1).getMonth()+'-');

                    $('#RangeDate_'+new Date().getDate()).html('今天');
                    RangeDateClick($('#RangeDate_'+new Date().getDate()));
                    RangeDateClick($('#RangeDate_'+($('#RangeDate_'+new Date().getDate()).attr('id').split('_')[1]*1+1)));

                    for(var i=new Date().getDate()-1;i>0;i--){
                        $('#RangeDate_'+i).addClass('RangeDate_dayNo');
                        $('#RangeDate_'+i)[0].onclick=null;
                    }
                    $('#'+RangeDateID).bind('click',function(){
                        $('#RangeDate').toggleClass('RangeDate_none');
                    });
                    $('.RangeDate_done').bind('click',function(){
                        console.log(RangeDate_start)
                        console.log(RangeDate_end)
                        if(!RangeDate_start && !RangeDate_end){
                            $('#RangeDate').addClass('RangeDate_none');

                            $('.entertime').text($('#'+RangeDate_startId).attr('data-id')); // 显示
                            $('.leavetime').text($('#'+RangeDate_endId).attr('data-id'));
                            $('.input-enter').val($('#'+RangeDate_startId).attr('data-id'));
                            $('.input-leave').val($('#'+RangeDate_endId).attr('data-id'));
                            $('.night').text('共' + (RangeDate_endId.split('_')[1]*1-RangeDate_startId.split('_')[1]*1) + '晚');

//                            $('#'+RangeDateID).val($('#'+RangeDate_startId).attr('data-id')+' 至 '+$('#'+RangeDate_endId).attr('data-id')+' 共'+(RangeDate_endId.split('_')[1]*1-RangeDate_startId.split('_')[1]*1)+'晚')
                        }
                    })
                }
                RangeDate('firstSelect')
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
                                            <em class="spec-pri"><?= $bed['name'] ?></em>
                                        </div>
                                        <div class="txt__el--down">
                                            <?= $bed['bed_name'] ?>（含早）
<!--                                            --><?//= $bed['breakfast'] ?>
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
