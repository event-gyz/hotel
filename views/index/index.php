<!DOCTYPE html>
<html style="font-size: 30px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link id="js_maincss" rel="Stylesheet" type="text/css" href="/css/n_main.css">
    <script src="/js/jquery-1.8.2.js"></script>

    <link rel="stylesheet" href="/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/css/ion.rangeSlider.skinHTML5.css">
    <link rel="stylesheet" href="/css/mobiscroll.css">
    <link rel="stylesheet" href="/css/photoswipe.css">
    <link rel="stylesheet" href="/css/photoswipe-default-skin.css">
    <link rel="stylesheet" href="/css/league_style.css">
    <link rel="stylesheet" href="/css/group.css">
    <link rel="stylesheet" href="/css/activity.css">

    <link rel="stylesheet" href="/css/calendar.css">
    <link rel="stylesheet" type="text/css" href="/css/date.css">

    <style type="text/css">object, embed {
            -webkit-animation-duration: .001s;
            -webkit-animation-name: playerInserted;
            -ms-animation-duration: .001s;
            -ms-animation-name: playerInserted;
            -o-animation-duration: .001s;
            -o-animation-name: playerInserted;
            animation-duration: .001s;
            animation-name: playerInserted;
        }

        @-webkit-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @-ms-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @-o-keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes playerInserted {
            from {
                opacity: 0.99;
            }
            to {
                opacity: 1;
            }
        }</style>
</head>
<body itemscope="" style="-webkit-touch-callout:none" class="env-PC">
<div class="main-container">

    <div id="js_style_root"></div>
    <div id="main" class="hotel-page-height100">
        <div class="main-frame">
            <div class="main-viewport">
                <div id="client_id_viewport_4_1534238575869">
                    <div class="list-main page__list--wrap">
                        <style>.js-fixed-content {
                                width: 100%;
                                background: #fff;
                                z-index: 1200
                            }

                            .g-banner img {
                                height: 100%
                            }</style>

                        <div class="mt-list-show g-list b2list">
                            <div id="checkinout">
                                <div id="firstSelect" style="width:100%;">
                                    <div class="Date_lr" style="float:left;">
                                        <p>入住</p>
                                        <input id="startDate" type="text" value="" style="" readonly="">
                                    </div>
                                    <div class="Date_lr" style="float:right;">
                                        <p>离店</p>
                                        <input id="endDate" type="text" value="" style="" readonly="">
                                    </div><span class="span21"><span class="NumDate">1</span>晚</span>
                                </div>
                            </div>
                            <div class="mask_calendar">
                                <div class="calendar">
                                    <div class="headerWrapper"
                                         style="height: 50px; line-height: 50px; width: 100%; background: rgb(255, 255, 255); position: fixed; z-index: 9999;">
                                        <div class="headerTip"
                                             style="text-align: left; line-height: 50px; margin-left: 10px; font-size: 15px;">
                                            请选择入住离店日期
                                        </div>
                                        <div class="comfire"
                                             style="height: 26px; line-height: 26px; width: 50px; color: rgb(46, 182, 168); position: absolute; right: 10px; text-align: center; font-size: 14px; cursor: pointer; top: 11px; border: 1px solid rgb(46, 182, 168); border-radius: 4px;">
                                            完成
                                        </div>
                                    </div>
                                    <table class="dateZone">
                                        <tbody>
                                        <tr>
                                            <td class="colo">日</td>
                                            <td>一</td>
                                            <td>二</td>
                                            <td>三</td>
                                            <td>四</td>
                                            <td>五</td>
                                            <td class="colo">六</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

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

                            <div class="js-list">
                                <ul class="mt-list-main ">
                                    <?php foreach ($hotel_list as $value) { ?>

                                        <li data-hotelid="<?= $value['id'] ?>" data-name="<?= $value['hotel_name'] ?>"
                                            data-channel="0" class="go_detail">
                                            <div class="mt-list-pic"><img class="" src="<?= $value['img'] ?>"
                                                                          alt="<?= $value['hotel_name'] ?>"></div>
                                            <div class="mt-list-word"><h2
                                                    class="ellips"><?= $value['hotel_name'] ?></h2>
                                                <div class="recom__item--extra">
                                                    <p class="h_icons_diamond8 h_icons"></p>
                                                    <span class="rec__it--score">
                                                    <em class="score">4.7</em>分
                                                </span>
                                                </div>
                                                <div class="box__item--disp"></div>
                                                <div class="txt__item--adr dfc">
                                                    <div class="txt__item--left">
                                                        <p class="sec-p"><?= $value['hotel_address'] ?></p>
                                                        <p class="sec-p loc__el--dist">距展馆 562m</p></div>
                                                    <div class="txt__item--right">
                                                    <span class="g-pri">
                            <b class="pri__spec--txt">专享价</b>
                                                        <span
                                                            class="pri__spec--ext">
                                                            <dfn>¥&nbsp;<em><?= $value['min_price'] ?></em></dfn>&nbsp;起/间
                                                        </span>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="tip-layer g-list-box"></div>

                    </div>
                </div>
            </div>
            <div class="main-state"></div>
        </div>
    </div>
    <div id="footer"></div>
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