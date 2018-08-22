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
    <title>酒店列表_会唐网</title>
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/lists.css" />
    <link rel="stylesheet" href="/public/hotel/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="/public/hotel/css/ion.rangeSlider.skinHTML5.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div class="list-main" id="app">
        <div id="main-box" style="display: none;">
        <div v-show="!isSearch">
            <!--head-->
            <form action="/hotel/listmap" id="listmap" method="post">
            <div class="list-main-head">
                <div class="list-search">
                    <p class="goBack" ><a href="javascript:;" @click="goBack"><i class="iconfont f20">&#xe605;</i></a></p>
                    <p class="search"><i class="iconfont search">&#xe620;</i><input readonly id="input-search" type="text" value="" placeholder="搜索" @click="worldSearch" :value="query_params.key_words" v-model="query_params.key_words"><i v-show="query_params.key_words" class="iconfont close" @click="clearText">&#xe69f;</i></p>
                    <p class="position">
                    <input type="hidden" name="locations" v-model='locations'>
                    <a href="javascript:;" @click="set_listMap"><i class="iconfont f20">&#xe61d;</i></a>
                    </p>
                </div>
                <table>
                    <tr>
                        <td :class="{cur:query_params.position!='' || query_params.location!=''}" class="border" @click="showHotelPosition">{{position_name}}&nbsp;<i v-if="query_params.position=='' && query_params.location==''" class="iconfont">&#xe61e;</i><i v-if="query_params.position!='' || query_params.location!=''" class="iconfont top">&#xe61c;</i></td>
                        <td :class="{cur:query_params.star_rate!='' || query_params.price!=''}" class="border" @click="showStar">{{price_name}}&nbsp;<i v-if="query_params.star_rate=='' && query_params.price==''" class="iconfont">&#xe61e;</i><i v-if="query_params.star_rate!='' || query_params.price!=''" class="iconfont top">&#xe61c;</i></td>
                        <td :class="{cur:query_params.roomMinPrice!='' || query_params.starSort!=''}" @click="showStore">{{sort_name}}&nbsp;<i v-if="query_params.roomMinPrice=='' && query_params.starSort==''" class="iconfont">&#xe61e;</i><i v-if="query_params.roomMinPrice!='' || query_params.starSort!=''" class="iconfont">&#xe61c;</i></td>
                    </tr>
                </table>
            </div>
            </form>
            <!--head-end-->
            <!--list-->
            <div class="list-main-list">
                <!--style-->
                <div class="style" v-for="item in msg">
                    <ul class="style-box">
                        <a :href="'/hotel/info?h_id='+item.place_id+'&c_id='+item.ctrip_id+'&city_location='+query_params.change_location+'&start_date='+start_date+'&end_date='+end_date+'&cur_location='+cur_location">
                        <li class="style-left"><img :src="item.main_pic_url"></li>
                        <li class="style-right">
                            <h3 v-text="item.place_name"></h3>
                            <p class="info" v-text="item.address"></p>
                            <p class="info" v-text="item.distance">sdfsdf</p>
                            <div class="price">
                                <p class="left"><i v-bind:class="setColor(item.star_code)" v-text="item.star_rate">xx</i></p>
                                <p class="right" v-if="item.price>1"><i>¥</i><b v-text="item.price">0</b><span>起</span></p>
                                <p class="right" v-else v-text="item.price"></p>
                            </div>
                        </li>
                        </a>
                    </ul>
                </div>
                <!--style-end-->
                <div v-if="isMore" @click="set_page" class="login-more">加载更多</div>
            </div>
            <!--list-->
            <!--pop-->
            <div class="list-pop">
                <!--酒店位置-->
                <table class="hotel-position" v-show="isPosition">
                    <tr>
                        <td class="left" valign="top">
                            <div class="select-position">
                                <p class="area cur" @click="show_class('area')">行政区域</p>
                                <p class="business" @click="show_class('business')">热门商圈</p>
                                <p class="airport" @click="show_class('airport')">机场</p>
                                <p class="train" @click="show_class('train')">火车站</p>
                                <p class="metro_line" @click="show_class('metro_line')">地铁周边</p>
                            </div>
                        </td>
                        <td class="right" valign="top">
                            <div class="right-style2 show-box" id="area">
                                <p class="allCon" :class="{cur:query_params.position == 'area_id-'+item.id }" v-for="item in position.area" :class="'allCon con'+item.id" @click="query('area',item.id,item.name,item.location)">{{item.name}}<i v-if="query_params.position == 'area_id-'+item.id" class="iconfont selected">&#xe699;</i></p>
                            </div>
                            <div class="right-style2 show-box" id="business" style="display: none">
                                <p class="allCon" :class="{cur:query_params.position == 'business_id-'+item.id }" v-for="item in position.business" :class="'allCon con'+item.id" @click="query('business',item.id,item.name,item.location)">{{item.name}}<i v-if="query_params.position == 'business_id-'+item.id" class="iconfont selected">&#xe699;</i></p>
                            </div>
                            <div class="right-style2 show-box" id="airport" style="display: none">
                                <p class="allCon" :class="{cur:query_params.position == 'airport_id-'+item.id }" v-for="item in position.airport" :class="'allCon con'+item.id" @click="query('airport',item.id,item.name,item.location)">{{item.name}}<i v-if="query_params.position == 'airport_id-'+item.id" class="iconfont selected">&#xe699;</i></p>
                            </div>
                            <div class="right-style2 show-box" id="train" style="display: none">
                                <p class="allCon" :class="{cur:query_params.position == 'train_id-'+item.id }" v-for="item in position.train" :class="'allCon con'+item.id" @click="query('train',item.id,item.name,item.location)">{{item.name}}<i v-if="query_params.position == 'train_id-'+item.id" class="iconfont selected">&#xe699;</i></p>
                            </div>
                            <!--style1-->
                            <table class="right-style1 show-box" cellpadding="0" id="metro_line" style="display: none">
                                <tr>
                                    <td class="style-left" valign="top">
                                        <div>
                                            <p :class="{cur:metro_line == item.id }" v-for="item in position.metro_line" :class="'allCon_class con_class'+item.id" @click="query_con(item.id)">{{item.name}}</p>
                                        </div>
                                    </td>
                                    <td class="style-right" valign="top">
                                        <div>
                                            <p class="allCon" :class="{cur:query_params.position == 'metro-'+item.id }" v-for="item in line" :class="'allCon con'+item.id" @click="query('metro',item.id,item.station_name,item.location)">{{item.station_name}}<i v-if="query_params.position == 'metro-'+item.id" class="iconfont selected">&#xe699;</i></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
                <!--酒店位置-end-->
                <!--排序-->
                <div class="hotel-sort" v-show="isSort">
                    <p :class="{cur:query_params.roomMinPrice== '' && query_params.starSort == ''}" @click="sortSearch(1,1,'推荐排序')">推荐排序<i v-if="query_params.roomMinPrice== '' && query_params.starSort == ''" class="iconfont selected">&#xe699;</i></p>
                    <p :class="{cur:query_params.starSort == 'desc'}" @click="sortSearch('star','desc','高星优先')">高星优先<i v-if="query_params.starSort == 'desc'" class="iconfont selected">&#xe699;</i></p>
                    <p :class="{cur:query_params.roomMinPrice== 'desc'}" @click="sortSearch('price','desc','高价优先')">高价优先<i v-if="query_params.roomMinPrice== 'desc'" class="iconfont selected">&#xe699;</i></p>
                    <p :class="{cur:query_params.roomMinPrice== 'asc'}" @click="sortSearch('price','asc','低价优先')">低价优先<i v-if="query_params.roomMinPrice== 'asc'" class="iconfont selected">&#xe699;</i></p>
                </div>
                <!--排序-end-->
                <!--星级/价格-->
                <div class="hotel-star-price"  v-show="isStar">
                    <div class="star">
                        <p class="title">星级 <span>(可多选)</span></p>
                        <p class="con">
                            <span :class="starShow(4)" @click="setStar(4)">4星/高档</span>
                            <span :class="starShow(5)" @click="setStar(5)">5星/豪华</span>
                            <span class="all" :class="starShow()" @click="setStar()">不限</span>
                            <span :class="starShow(2)" @click="setStar(2)">2星/经济</span>
                            <span :class="starShow(3)" @click="setStar(3)">3星/舒适</span>
                        </p>
                    </div>
                    <div class="price">
                        <p class="title">价格</p>
                        <p class="price-scope">¥<input type="number" readonly v-model="price_from">&nbsp;&nbsp;-&nbsp;&nbsp;¥<input type="number" readonly v-model="price_to"></p>
                        <input type="hidden" id="range_02" class="irs-hidden-input" tabindex="-1" readonly="">
                        <p class="price-scope-show"><span class="left">¥0</span><span class="right">不限</span></p>
                    </div>
                    <div class="hotel-button">
                        <a href="javascript:;" class="clear-con" @click="priceClear">清空选项</a>
                        <a href="javascript:;" class="submit" @click="priceSubmit">确定</a>
                    </div>
                </div>
                <!--星级/价格-end-->
            </div>
            <!--pop-end-->
        </div>
        <!-- 搜索 -->
        <section v-show="isSearch" :class="isSearch ? 'page page-next page-in' :'page page-next'" id="searchPage">
                <div class="weui-search-bar weui-search-bar_focusing" id="searchBar">
                    <label @click="searchCancel"><i class="iconfont f20" style="color:#867c7c">&#xe605;</i></label>
                    <form class="weui-search-bar__form">
                        <div class="weui-search-bar__box">
                            <i class="weui-icon-search"></i>
                            <input type="search" class="weui-search-bar__input" id="searchInput" placeholder="输入酒店名／地名／地标／商圈" required="" :value="seachWorld" v-model="seachWorld">
                            <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
                        </div>
                        <label class="weui-search-bar__label" id="searchText">
                            <i class="weui-icon-search"></i>
                            <span>搜索</span>
                        </label>
                    </form>
                    <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel"  @click="tosearch">搜索</a>
                </div>
                <div class="searchPage-title" v-if="arrcookie.length>0">
                    <p class="left">搜索历史</p>
                    <p class="right" @click="clearHistory">清楚历史</p>
                </div>
                <!--搜索列表-->
                <table class="search-list" v-if="arrcookie.length>0">
                    <tr v-for="item in arrcookie" @click="seletedItem(item.name,item.location,item.cid,item.cname,item.otherlocation)">
                        <td class="left">{{item.name}}</td>
                    </tr>
                </table>
                <!--搜索列表-end-->
                <div class="searchPage-title" v-if="currentCitySearchData.length>0">
                    <p class="left">当前城市查询结果</p>
                </div>
                <!--搜索列表-->
                <table class="search-list" v-if="currentCitySearchData.length>0">
                    <tr v-for="item in currentCitySearchData" @click="seletedItem(item.place_name,item.location,query_params.city_id,query_params.city_name,query_params.change_location)">
                        <td class="left"><!-- <span>天津</span> -->{{item.place_name}}<i>{{query_params.city_name}}</i></td>
                    </tr>
                </table>
                <div class="searchPage-title" v-if="otherCitySearchData.key">
                    <p class="left">其他城市查询结果</p>
                </div>
                <table class="search-list" v-if="otherCitySearchData.key">
                    <tr v-for="item in otherCitySearchData.info.otherCityData"
                     @click="seletedItem(item.place_name,item.location,otherCitySearchData.info.otherCityInfo.city_id,otherCitySearchData.info.otherCityInfo.city_name,otherCitySearchData.location)">
                        <td class="left">{{item.place_name}}<i>{{otherCitySearchData.info.otherCityInfo.city_name}}</i></td>
                    </tr>
                </table>
        </section>
        <!-- 搜索 -end-->
        <div id="mask" v-show="isMask" @click="hide_mask"></div>
        </div>
    </div>
    <div id="global_login"></div>
    <script src="/public/hotel/js/jquery.js"></script>
    <script src="/public/hotel/js/jquery.cookie.js"></script>
    <script src="/public/hotel/js/ion.rangeSlider.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8&services=&t=20170823191629"></script>
    <script src="/public/hotel/js/lists.js"></script>
</body>
</html>
