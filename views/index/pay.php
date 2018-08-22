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
    <title>酒店预订_会唐网</title>
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/pay.css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div id="app">
    <div style="display: none" id="main-box">
    <div class="pay" :style="{height:screenHeight+'px'}">
        <div class="pay-top">
            <!--nav-title-end-->
            <div class="nav-title" style="background: none;"><i class="iconfont f20" @click="goBack" style="color: #fff;">&#xe605;</i><h2 style="background: none;color: #fff;">预订信息填写</h2></div>
            <!--nav-title-end-->
            <div class="pay-top-box">
                <div class="name" v-text="msg.hotel_name"></div>
                <div class="info">
                    <p class="title">{{msg.hotel_address}}</p>
                    <p class="date"><span><b>入住：</b>{{start_cn}}</span><span><b>离店：</b>{{end_cn}}</span><span>共{{msg.gap_day}}晚</span></p>
                    <p class="room-style"><span>{{msg.roomName}}</span><span>{{msg.room_name}}</span><span>{{msg.bedInfo}}</span><span>{{msg.breakfast}}</span></p>
                </div>
            </div>
        </div>
        <div class="pay-con-box">
            <table border="0" cellspacing="0">
                <tr>
                    <td class="left">房间数</td>
                    <td>{{msg.room_number}}间</td>
                    <td class="right select-room-len">
                        <i class="iconfont down" v-show="!msg.isShowRoom" @click="showRoom(1)">&#xe610;</i>
                        <i class="iconfont top"  v-show="msg.isShowRoom" @click="showRoom(0)">&#xe60f;</i>
                    </td>
                </tr>
                <tr class="room-num no-bg" v-show="msg.isShowRoom">
                    <td colspan="3" align="center">
                        <span :class="{disabled:AvailableQuantity<1,cur:msg.room_number==1}" @click="setRoomLength(1)">1间</span>
                        <span :class="{disabled:AvailableQuantity<2,cur:msg.room_number==2}" @click="setRoomLength(2)">2间</span>
                        <span :class="{disabled:AvailableQuantity<3,cur:msg.room_number==3}" @click="setRoomLength(3)">3间</span>
                        <span :class="{disabled:AvailableQuantity<4,cur:msg.room_number==4}" @click="setRoomLength(4)">4间</span>
                        <span :class="{disabled:AvailableQuantity<5,cur:msg.room_number==5}" @click="setRoomLength(5)">5间</span>
                    </td>
                </tr>
                <tr class="no-bg">
                    <td class="left">入住人</td>
                    <td colspan="2" class="room-name">
                        <p  v-for="(item,index) in msg.room_number" class="table-pos-p"><span><input type="text" maxlength="6" placeholder="输入姓名" v-model="msg.person[index]"></span></p>
                    </td>
                </tr>
                <tr>
                    <td class="left">联系方式</td>
                    <td><input type="text" v-model="msg.contacter_phone"></span></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="left">备注</td>
                    <td :class="{cur:msg.order_requirement == '优先大床'}">优先大床<span v-show="msg.order_requirement == '优先大床'">（尽量安排）</span></td>
                    <td class="right" @click="setOrder_requirement('优先大床')">
                        <i v-show="msg.order_requirement == '优先大床'" class="iconfont">&#xe69a;</i>
                        <i v-show="msg.order_requirement != '优先大床'" class="iconfont">&#xe6a2;</i>
                    </td>
                </tr>
                <tr class="no-bg">
                    <td class="left"></td>
                    <td :class="{cur:msg.order_requirement == '优先双床'}">优先双床<span v-show="msg.order_requirement == '优先双床'">（尽量安排）</span></td>
                    <td class="right" @click="setOrder_requirement('优先双床')">
                        <i v-show="msg.order_requirement == '优先双床'" class="iconfont">&#xe69a;</i>
                        <i v-show="msg.order_requirement != '优先双床'" class="iconfont">&#xe6a2;</i>
                    </td>
                </tr>
            </table>
        </div>
        <div class="pay-con-box">
            <div class="ticket-msg">
                <ul class="left">发票信息</ul>
                <ul class="right ticket-switch">
                    <li @click="select_is_invoice":class="{'ticket-open':msg.is_invoice}" style="background:url('/public/hotel/images/switch.png') no-repeat 0 0;">
                    </li>
                </ul>
            </div>
            <table class="invoice-table" v-show="msg.is_invoice">
                <tr>
                    <td class="left">发票类型</td>
                    <td>
                        <label style="margin-right: 15px;" class="person" @click="select_invoice_type(1)"><i class="iconfont" v-show="msg.invoice_type == 2">&#xe6a2;</i><i class="iconfont" v-show="msg.invoice_type == 1" >&#xe69a;</i>&nbsp;个人</label>
                        <label class="company" @click="select_invoice_type(2)"><i class="iconfont" v-show="msg.invoice_type == 1">&#xe6a2;</i><i class="iconfont" v-show="msg.invoice_type == 2">&#xe69a;</i>&nbsp;公司</label>
                    </td>
                </tr>
                <tr>
                    <td class="left">发票明细</td>
                    <td class="right-span">
                        <span>订房费</span>
                        <span>{{msg.roomAllPrice}}元</span>
                    </td>
                </tr>
                <tr>
                    <td class="left">发票抬头</td>
                    <td><input v-model="msg.invoice_title" class="ticket-title" type="text" placeholder="填写名称"></td>
                </tr>
                <tr class="identify" v-show="msg.invoice_type==2">
                    <td class="left">纳税人识别号</td>
                    <td><input v-model="msg.taxpayer_number" type="text" placeholder="纳税人识别号"></td>
                </tr>
                <tr>
                    <td class="left">收件人</td>
                    <td><input v-model="msg.consignee" type="text" placeholder="收件人"></td>
                </tr>
                <tr>
                    <td class="left">手机号</td>
                    <td><input v-model="msg.phone" type="text" placeholder="手机号"></td>
                </tr>
                <tr>
                    <td class="left">地址</td>
                    <td><input v-model="msg.address" type="text" id="city-picker" style="width:100%;padding:8px 5px;border:none;" readonly placeholder="选择所在省份／城市"></td>
                </tr>
                <tr>
                    <td class="left">详细地址</td>
                    <td><input v-model="msg.address_info" type="text" placeholder="详细地址"></td>
                </tr>
                <tr>
                    <td class="left">快递费</td>
                    <td class="right-span"><span>10元</span></td>
                </tr>
            </table>
        </div>
        <div class="pay-terms">
            <p><span>预订须知：</span>此为向代理商申请的特殊价格，我们会在一小时以内提供预订结果，请您耐心等待，到达酒店前台后请直接报入住客人姓名办理入住。</p>
            <p v-if="msg.policyType == '不可取消'"><span>取消规则：</span>订单确认后不可变更取消，若未入住将收取您全额房费￥{{msg.roomAllPrice}}，订单不确认将全额退款至您的付款账户。附加服务费用将与房费同时扣除或返还。</p>
            <p v-else-if="msg.policyType == '免费取消'"><span>取消规则：</span>订单提交后，入住前可随时联系会唐网取消，不收取任何费用。</p>
            <p v-else-if="msg.policyType == '限时取消'"><span>取消规则：</span>{{tip_text}}</p>
        </div>
    </div>
    <div class="pay-info">
        <p class="left">
            <span class="info-left">总价:<i class="min">¥</i><i class="max">{{msg.allPrice}}</i></span>
            <span class="info-right" id="show-price-info" @click="show_info">明细&nbsp;<i class="iconfont down" v-show="msg.is_info">&#xe610;</i><i class="iconfont top" v-show="!msg.is_info">&#xe60f;</i></span>
        </p>
        <p class="right has_buy" v-if="!is_submit_ing" @click="save">立即预订</p>
        <p class="right no_buy" v-if="is_submit_ing" style="background: #ccc;">{{text}}</p>
    </div>
    <!--pop-->
    <div class="pay-info-pop" :class="{'pop-go-top':msg.is_info}">
        <div class="title">明细</div>
        <div class="table-box">
            <table>
                <tr>
                    <td colspan="3">
                        <ul class="price-all">
                            <li class="left">房费</li>
                            <li class="right">¥{{msg.roomAllPrice}}</li>
                        </ul>
                        <ul class="price-all-list">
                            <li v-for="(item,index) in priceList">
                                <p class="left">{{item.date}}</p>
                                <p class="center">{{msg.breakfast}}</p>
                                <p class="right">{{msg.room_number}} x ¥{{item.price}}</p>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr v-show="msg.is_invoice">
                    <td align="left">快递费</td>
                    <td align="right">¥10</td>
                </tr>
                <tr>
                    <td align="left">总价</td>
                    <td align="right">
                        <p>¥{{msg.allPrice}}</p>
                        <p class="color">{{msg.pay_type == 1?'在线付':'到店付'}} {{msg.policyType}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!--pop-end-->
    <div id="global-max" @click="close"></div>
    </div>
    </div>
    <div id="global_login"></div>
    <script src="/eventown/js/zepto.min.js"></script>
    <script src="/public/hotel/js/zepto.cookie.js"></script>
    <script src="/public/hotel/js/jquery-weui.js"></script>
    <script src="/public/hotel/js/city-picker.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/moment.min.js"></script>
    <script src="/public/hotel/js/pay.js"></script>
</body>
</html>




