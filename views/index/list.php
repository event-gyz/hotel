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
                        comeColor: "#4FA9FF",       //入住颜色
                        outColor: "#4FA9FF",      //离店颜色
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
