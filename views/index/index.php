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
    <title>开会,订房,上会唐</title>
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <link rel="stylesheet" href="/public/hotel/css/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="/public/hotel/css/hotel-common.css" />
    <link rel="stylesheet" href="/public/hotel/css/index.css" />
    <link rel="stylesheet" href="//cdn.bootcss.com/jquery-weui/1.0.1/css/jquery-weui.min.css">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/1.1.1/style/weui.min.css">
    <style type="text/css">
    #header{
        background: rgb(66, 131, 230)!important
    }
    .hidden{
        display: none;
    }
    .close{
        position: absolute;
        top: 10px;
        right: 0;
    }
    #cnzz_stat_icon_1264519856 img{
        display: none;
    }
    </style>
</head>
<body>
    <?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div id="app">
        <div id="main-box" style="display: none;">
        <div :class="ispage ? 'main' : 'main hidden'">
            <div class="main-top">
                <!--banner-->
                <div class="main-banner">
                    <div class="swiper-container" style="height:420px;">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide" v-for="item in Swiper">
                            <a class="swiper-bg" :href="item.url" :style="{backgroundImage: 'url(' + item.img + ')'}"></a>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <p class="go-user">
                        <a href="/newweixin/login?to_url=%2Fhotel%2Findex#login_code" v-if="userid==null"><i class="iconfont">&#xe63b;</i></a>
                        <a href="/personal/center" v-if="userid!=null" style="color:#fff"><i class="iconfont" style="float:left">&#xe63b;</i><span style="max-width: 80px; overflow: hidden;text-overflow: ellipsis;white-space: nowrap;display: block;margin-left: 25px;line-height: 40px;">{{userName}}</span></a>
                    </p>
                </div>
                <!--banner-end-->
                <!--search-->
                <div class="main-search">
                    <table>
                        <tr class="border">
                            <td width="50" style="text-algin:left"><p class="table-title" style="text-align:left">目的地</p></td>
                            <td>
                                <span class="weui-input" id="select-city" @click="cityList">{{cityName}}</span>
                                <span class="hidden">{{cityId}}</span>
                            </td>
                            <td width="50"  style="text-algin:left" @click="getCur_location">
                                <p><i class="iconfont">&#xe6a7;</i></p>
                                <p>当前位置</p>
                            </td>
                        </tr>
                        <tr class="border">
                            <td colspan="3">
                                <table class="inner-table" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="30"><p class="table-title">日期</p></td>
                                        <td>
                                            <p class="time-sm">入住</p>
                                            <p class="time-string">
                                                <input type="text" id="data-start" :value="startTime" readonly="readonly">
                                                <span>{{sWeek}}</span>
                                            </p>
                                        </td>
                                        <td><span class="day">{{day}}晚</span></td>
                                        <td>
                                            <p class="time-sm">离店</p>
                                            <p class="time-string">
                                                <input type="text" id="data-end" :value="endTime" readonly="readonly">
                                                <span>{{eWeek}}</span>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr class="border">
                            <td width="50"><p class="table-title"  style="text-align:left;margin-left:3px">搜索</p></td>
                            <td colspan="2" style="position:relative;">
                            <input type="text" id="input-search" style="width:80%;border:none;text-align:center;font-size:15px;" placeholder="输入酒店名／地名／地标／商圈"  @click="citysearch($event)"
                             :value="searchRultsName" v-model="searchRultsName">
                             <i v-show="searchRultsName!=''" class="iconfont close" @click="clearText">&#xe69f;</i>
                             <input type="hidden" :value="searchRultsLocation" v-model="searchRultsLocation">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"><a href="javascript:;" class="weui-btn" style="background: #4283e6;" @click="searchList(1)">搜索酒店</a></td>
                        </tr>
                    </table>
                </div>
                <!--search-end-->
            </div>
            <div class="main-bottom">
                <div class="box">
                    <table>
                        <tr>
                            <td>
                                <a href="/combo/tourism">
                                    <p><img src="/public/hotel/images/z_img1.jpg"></p>
                                </a>
                            </td>
                            <td>
                                <a href="/combo/ship">
                                    <p><img src="/public/hotel/images/z_img2.jpg"></p>
                                </a>
                            </td>
                            <td>
                                <a href="/combo/visa">
                                    <p><img src="/public/hotel/images/z_img3.jpg"></p>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div><img style="width: 100%" src="/public/hotel/images/bottom-img.png"></div>
            </div>
        </div>
        <section :class="cityContainer ? 'page page-city page-next page-in' : 'page page-city page-next'" :style="{display:block}" id="cityPage" >
            <header id="header">
                <div class="icon-back" data-page="page-index" @click="cityListBack">
                    <i class="iconfont f18 text-muted">&#xe605;</i>
                </div>
                <h1 class="text-overflow">选择城市</h1>
            </header>
            <div class="container">
                <div class="list-block contacts-block city-list" id="cityContainer">
                    <div class="list-group">
                        <ul v-for="(item,index) in city[0]">
                            <li class="list-group-title" v-if="index=='热门城市'">{{index}} </li>
                            <li class="city" v-for="el in item"  :id="el.areaid" :name="el.name" @click="selectCity(el.areaid,el.name,el.location)" :location="el.location" v-if="index=='热门城市'">{{el.name}} </li>
                        </ul>
                        <ul v-for="(item,index) in city[0]">
                            <li class="list-group-title" v-if="index!='热门城市'">{{index}} </li>
                            <li class="city" v-for="el in item"  :id="el.areaid" :name="el.name" @click="selectCity(el.areaid,el.name,el.location)" :location="el.location"  v-if="index!='热门城市'">{{el.name}} </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section :class="seachName ? 'page page-next page-in' : 'page page-next'"  id="searchPage">

            <div class="weui-search-bar weui-search-bar_focusing" id="searchBar">
                <label @click="searchCancel"><i class="iconfont f20" style="color:#867c7c">&#xe605;</i></label>
                <form class="weui-search-bar__form"  @submit.prevent="submit">
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
                <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel" @click="toList">搜索</a>
            </div>
            <div class="searchPage-box">
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
                    <tr v-for="item in currentCitySearchData" @click="seletedItem(item.place_name,item.location,cityId,cityName,city_location)">
                        <td class="left"><!-- <span>天津</span> -->{{item.place_name}}<i>{{cityName}}</i></td>
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
<!--                     <tr>
                        <td class="left"><span>天津</span>盘山风景区<i>天津市</i></td>
                        <td class="right">商圈</td>
                    </tr> -->
                </table>
            </div>
        </section>
    </div>
    </div>
    <div id="global_login"></div>
    <script src="/eventown/js/zepto.min.js"></script>
    <script src="/public/hotel/js/zepto.cookie.js"></script>
    <script src="/public/hotel/js/jquery-weui.js"></script>
    <script src="/public/hotel/js/city-picker.js"></script>
    <script src="/public/hotel/js/swiper-3.3.1.jquery.min.js"></script>
    <script src="/public/hotel/js/moment.min.js"></script>
    <script src="/public/hotel/js/util.js"></script>
    <script src="/public/hotel/js/vue.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/getscript?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8&services=&t=20170823191629"></script>
    <script src="/public/hotel/js/index.js"></script>
    <!-- 友盟统计 -->
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1264519856'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/z_stat.php%3Fid%3D1264519856%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
</body>
</html>
