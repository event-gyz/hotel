<!DOCTYPE html>
<html style="font-size: 30px;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>酒店预订</title>
    <link id="js_maincss" rel="Stylesheet" type="text/css" href="/css/n_main.css">
    <link rel="stylesheet" href="/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/css/ion.rangeSlider.skinHTML5.css">
    <link rel="stylesheet" href="/css/mobiscroll.css">
    <link rel="stylesheet" href="/css/photoswipe.css">
    <link rel="stylesheet" href="/css/photoswipe-default-skin.css">
    <link rel="stylesheet" href="/css/league_style.css">
    <link rel="stylesheet" href="/css/group.css">
    <link rel="stylesheet" href="/css/activity.css">
    <script src="/js/jquery-1.8.2.js"></script>
    <script src="/js/jquery.form.js"></script>
    <style>
        .env-miniapp #main.hotel-page-height100, .hotel-page-height100 {
            height: calc(100% - 64px) !important
        }


        .cui-error-tips {
            border-bottom: none
        }</style>

</head>
<bodystyle="-webkit-touch-callout:none" class="env-PC">
<div class="main-container">
    <div id="headerview" style="height: 44px;">
        <div class="cm-header cm-header--no-right" id="ui-view-11" style="">
            <span class=" cm-header-icon fl  js_back">
        
          <i class="icon-back"></i>
        
      </span>


            <h1 class="cm-page-title js_title">

                填写订单信息

            </h1>


        </div>
    </div>
    <div id="main" class="hotel-page-height100">
        <div class="main-frame">
            <div class="main-viewport">
                <div id="client_id_viewport_1_1534240374015" page-url="/webapp/meeting/b2croom/dsjsh2439/list"
                     data-view-name="b2croom/list" style="display: none;">
                    <div class="list-main page__list--wrap">
                        <div class="mt-list-show g-list b2list">
                            <div class="js_tabfilter_box js_cal_bar" id="js_tabfilter_box" style="height:2.45rem">
                                <div class="g-date df a-i-c bor-top-btm date__item--ht js-fixed-content">
                                    <div class="g-in fx1 js_room_cal" data-type="room_in"><p>入住</p>
                                        <p class="date-t">8月22日 周三</p></div>
                                    <span class="diff">1晚</span>
                                    <div class="g-in fx1 js_room_cal" data-type="room_out"><p>离店</p>
                                        <p class="date-t">8月23日 周四</p></div>
                                </div>
                            </div>
                        </div>
                        <div class="g-submit js-tips" style=""><p class="bor-top-btm df a-i-c "><i class="g-icon-a"></i>温馨提示
                            </p></div>
                        <div class="tip-layer g-list-box"></div>

                    </div>
                </div>

                <div id="client_id_viewport_3_1534240391899" data-view-name="b2croom/order" style="">
                    <article class="page__main--wrap m js_index_article  mt-order-bg calc" style="">
                        <div id="cart">
                            <div class="g-order-login page__main--wrap">
                                <dl class="shop_list shopList">
                                    <dt class="shop_list-dt">
                                    <h4 class="shop_list_title">
                                        <em class="tit__el--sub"><?=$hotel_info['hotel_name']?></em>
                                        <span class="type__el--ext"style="max-width:25%">
                                            <?=$room_info['room_name']?>
                                        </span>
                                    </h4>
                                    </dt>
                                    <dd data-jsid="1441_2018-8-22_2018-8-23" data-type="room" data-ordertype=""
                                        data-breakfasttype="1"><h5 style="display:none">豪华房&nbsp;&nbsp;&nbsp;&nbsp;大床&nbsp;/&nbsp;单早</h5>
                                        <div class="shop_list-box"><p class="shop_list-date">

                                                <?=$bed_info['bed_name']?>&nbsp;&nbsp;&nbsp;&nbsp;<em><?=$bed_info['breakfast']?></em></p>
                                        </div>
                                        <div class="shop_list-box">
                                            <p class="shop_list-date"><?=date('m月d日',strtotime($_GET['startDate']))?> - <?=date('m月d日',strtotime($_GET['endDate']))?>&nbsp;&nbsp;&nbsp;&nbsp;<em><?php echo (strtotime($_GET['endDate'])-strtotime($_GET['startDate']))/86400?>晚</em>
                                            </p>
                                            <span class="a-i-c">单价<em class="g-orange">¥&nbsp;
                                                    <strong
                                                        style="font-size:0.8rem"><?=$bed_info['price']?></strong></em>
                                            </span>
                                        </div>


                                        <input style="display:none" class="num nofastclick" type="text" value="1"
                                               maxlength="3" data-num="1"></dd>
                                </dl>
                                <div class="inInfo"><p class="inInfo-ic1">
                                        温馨提示：此价格是为本次活动向酒店申请的特殊价格，不适合用于本活动以外的任何其他预订渠道。<span>若无中国居民身份证，请在【更多需求】中提前告知。</span>
                                    </p>
                                    <p>取消修改说明：该订单确认后不可取消修改，若未入住或取消，全部或部分房费不予退还。如订单不确认将解除预授权或全额退款至您的付款账户。</p></div>
                            </div>
                        </div>
                        <ul id="coupons" class="coupon"></ul>
                        <div class="fill-main main__unit--info" id="contactinfo">
                            <form id="orderForm" method="post" enctype="multipart/form-data" name="orderForm">
                                <input type="hidden" value="<?php echo Yii::$app->request->csrfToken; ?>" name="_csrf" >
                            <div class="head__item--sub bor-bottom">
                                <strong class="item__title--emp">预订信息</strong>
                            </div>
                            <ul class="fill-info">
                                <li class="user__item--check dfc Occupant">
                                    <div class="grid__it--left">
                                        <div class="bor-bottom">
                                            <span class="u__name" data-show="namerulesdesc">
                                                <span class="red">∗</span>房间数量</span>
                                            <input type="number" maxlength="50" value="1" placeholder="房间数量" class="conname" id="num" name="num">
                                        </div>
                                    </div>
                                </li>
                                <li class="user__item--check dfc Occupant">
                                    <div class="grid__it--left">
                                        <div class="bor-bottom">
                                            <span class="u__name" data-show="namerulesdesc">
                                                <span class="red">∗</span>入住人</span>
                                            <input type="text" maxlength="50" value="" placeholder="填写住客姓名" class="conname" name="name">
                                        </div>
                                    </div>
                                </li>
                                <li class="user__item--check dfc Occupant">
                                    <div class="grid__it--left">
                                        <div class="bor-bottom">
                                            <span class="u__name" data-show="namerulesdesc">
                                                <span class="red">∗</span>联系人</span>
                                            <input type="text" maxlength="50" value="" placeholder="姓名" class="conname"  name="content_name">
                                        </div>
                                    </div>
                                </li>
                                <li class="user__item--check dfc Occupant">
                                    <div class="grid__it--left">
                                        <div class="bor-bottom">
                                            <span class="u__name" data-show="namerulesdesc">
                                                <span class="red">∗</span>联系手机</span>
                                            <input type="text" maxlength="50" value="" placeholder="11位手机号码" class="conname"  name="content_phone">
                                        </div>
                                    </div>
                                </li>
                                <li class="user__item--check dfc Occupant">
                                    <div class="grid__it--left">
                                        <div class="bor-bottom">
                                            <span class="u__name" data-show="namerulesdesc">Email</span>
                                            <input type="text" maxlength="50" value="" placeholder="请填写邮箱地址" class="conname"  name="email">
                                        </div>
                                    </div>
                                </li>
                                <input type="hidden" value="<?=$_GET['startDate']?>" name="check_in_time">
                                <input type="hidden" value="<?=$_GET['endDate']?>" name="check_out_time">
                                <input type="hidden" value="<?=$bed_info['id']?>" name="bed_id">
                                <input type="hidden" value="<?=$bed_info['room_id']?>" name="room_id">
                                <li class="user__item--check dfc Occupant">

                                </li>
                            </ul>
                        </div>
                        </form>
                        <div class="back-info" id="notice"><p>点击提交订单表示您已阅读并了解<span
                                    class="light-blue">&nbsp;预订须知和退改政策</span></p></div>
                        <div class="footer__item--box" style="">
                            <div id="pricesum" class="shop-list--order shop-fixed footer__item--bottom bor-top dfc ">
                                <div class="g-add-down ">
                                    <ul class="g-detail-btn">
                                        <li class="g-first-pri">在线支付<dfn>¥&nbsp;<em class="j-tot-price"><?=(strtotime($_GET['endDate'])-strtotime($_GET['startDate']))/86400*$bed_info['price']?></em></dfn>
                                        </li>
                                        <li class="shop-pay--b2croom">去支付</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <div class="main-state"></div>
        </div>
    </div>
    <div id="footer"></div>
</div>

<div class="view cui-mask"
     style="width: 100%; height: 1281px; position: absolute; left: 0px; top: 0px; z-index: 3005; display: none;"
     id="ui-view-16">

</div>
<script>

    $("#num").change(function(){
        var night = <?=(strtotime($_GET['endDate'])-strtotime($_GET['startDate']))/86400?>;
        var price = <?= $bed_info['price']?>;
        var num = $('#num').val();
        $('.j-tot-price').text(num*night*price);
    })

    $('.shop-pay--b2croom').click(function(){
        $('#orderForm').ajaxSubmit(      //ajax方式提交表单
            {
                url: '/index/pay-order',
                type: 'post',
                dataType: 'json',
                beforeSubmit: function () {},
                success: function (data) {
                    if (data.res == "True" || data.res == true) {
                        $('.jsrz_main_check').html('您的申请已提交，我们将会在1-2个工作日内进行审核，请耐心等待!');
                    } else {
                        alert(data.msg);
                    }
                },
                clearForm: false,//禁止清楚表单
                resetForm: false //禁止重置表单
            });
    })
</script>
</body>
</html>