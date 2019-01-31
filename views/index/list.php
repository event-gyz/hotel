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
    <link rel="stylesheet" href="/css/lists.css"/>
    <link rel="stylesheet" href="/css/calendar.css"/>
    <link rel="stylesheet" href="/css/index-date.css"/>
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
            width: 50%;
            font-size: 16px;
            color: #4189ff;
            text-align: center;
        }
        .time{
            color: #4189ff;
            font-size: 16px;
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
</head>
<body>
<div class="list-main" id="app">
    <div id="main-box">
        <div>
            <!--head-->
            <div class="list-main-head">
                <h1 class="cm-page-title js_title" style="line-height: 15px;
    font-size: 18px;top: 0; height: 15px; text-align: center; color: #fff;font-weight: 400; z-index: 960;">
                    选择酒店
                </h1>
            </div>


            <div id="checkinout" class="row select-time">
                <div id="firstSelect" style="width:100%;">
                    <div class="Date_lr" style="float:left;">
                        <P>入住</p>
                        <span class="time entertime"><?= date('Y-m-d')?></span>
                        <input id="startDate" class="input-enter none" type="text" value="<?= date('Y-m-d')?>" style="" readonly>
                    </div>
                    <div class="Date_lr" style="float:right;">
                        <p>离店</p>
                        <span class="time leavetime"><?= date("Y-m-d",strtotime("+1 day"))?></span>
                        <input id="endDate" class="input-leave none" type="text" value="<?= date("Y-m-d",strtotime("+1 day"))?>" style="" readonly>
                    </div>
                    <span class="span21 night">共<span class="NumDate">1</span>晚</span>
                </div>
            </div>
            <div class="mask_calendar">
                <div class="calendar"></div>
            </div>

            <script type="text/javascript" src="/js/jquery.min.js"></script>
<!--            <script type="text/javascript" src="/js/date.js"></script>-->
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
<!--            <script>-->
<!--                $(function () {-->
<!--                    $('#firstSelect').on('click', function () {-->
<!--                        $('.mask_calendar').show();-->
<!--                    });-->
<!--                    $('.mask_calendar').on('click', function (e) {-->
<!--                        if (e.target.className == "mask_calendar") {-->
<!--                            $('.calendar').slideUp(200);-->
<!--                            $('.mask_calendar').fadeOut(200);-->
<!--                        }-->
<!--                    })-->
<!--                    $('#firstSelect').calendarSwitch({-->
<!--                        selectors: {-->
<!--                            sections: ".calendar"-->
<!--                        },-->
<!--                        index: 4,      //展示的月份个数-->
<!--                        animateFunction: "slideToggle",        //动画效果-->
<!--                        controlDay: true,//知否控制在daysnumber天之内，这个数值的设置前提是总显示天数大于90天-->
<!--                        daysnumber: "90",     //控制天数-->
<!--                        comeColor: "#4FA9FF",       //入住颜色-->
<!--                        outColor: "#4FA9FF",      //离店颜色-->
<!--                        comeoutColor: "#E0F4F2",        //入住和离店之间的颜色-->
<!--                        callback: function () {//回调函数-->
<!--                            $('.mask_calendar').fadeOut(200);-->
<!--                            var startDate = $('#startDate').val();  //入住的天数-->
<!--                            var endDate = $('#endDate').val();      //离店的天数-->
<!--                            var NumDate = $('.NumDate').text();    //共多少晚-->
<!--                            console.log(startDate);-->
<!--                            console.log(endDate);-->
<!--                            console.log(NumDate);-->
<!--                            //下面做ajax请求-->
<!--                            //show_loading();-->
<!--                            /*$.post("demo.php",{startDate:startDate, endDate:endDate, NumDate:NumDate},function(data){-->
<!--                             if(data.result==1){-->
<!--                             //成功-->
<!--                             } else {-->
<!--                             //失败-->
<!--                             }-->
<!--                             });*/-->
<!--                        },-->
<!--                        comfireBtn: '.comfire'//确定按钮的class或者id-->
<!--                    });-->
<!--                    var b = new Date();-->
<!--                    var ye = b.getFullYear();-->
<!--                    var mo = b.getMonth() + 1;-->
<!--                    mo = mo < 10 ? "0" + mo : mo;-->
<!--                    var da = b.getDate();-->
<!--                    da = da < 10 ? "0" + da : da;-->
<!--                    $('#startDate').val(ye + '-' + mo + '-' + da);-->
<!--                    b = new Date(b.getTime() + 24 * 3600 * 1000);-->
<!--                    var ye = b.getFullYear();-->
<!--                    var mo = b.getMonth() + 1;-->
<!--                    mo = mo < 10 ? "0" + mo : mo;-->
<!--                    var da = b.getDate();-->
<!--                    da = da < 10 ? "0" + da : da;-->
<!--                    $('#endDate').val(ye + '-' + mo + '-' + da);-->
<!--                });-->
<!--            </script>-->


            <!--head-end-->
            <!--list-->
            <div class="list-main-list">
                <!--style-->
                <?php foreach ($hotel_list as $value) { ?>
                    <div class="style">
                        <ul class="style-box go_detail" data-hotelid="<?= $value['id'] ?>" >
                            <li class="style-left"><img class="" src="<?= $value['img'] ?>"
                                                        alt="<?= $value['hotel_name'] ?>"></li>
                            <li class="style-right">
                                <h4 style="display:inline"><?= $value['hotel_name'] ?></h4>
                                <span style="font-size:10px">(2月23日～3月2日)</span>
                                <br/>
                                <br/>
                                <p class="info"><?= $value['hotel_address'] ?></p>
                                <div class="price">
                                    <p class="left"><?= $value['distances'] ?></p>
                                    <p class="right"><i>¥</i><b><?= $value['min_price'] ?></b><span>起</span></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
                <!--style-end-->
            </div>
            <!--list-->
        </div>
    </div>
</div>

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
