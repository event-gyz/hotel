/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */

// 定义全局
$('.combo-list-nav li').eq(0).hide()
$('.combo-list-nav li').eq(1).addClass('active');
$('.combo-list-body div.tab-body').eq(1).addClass('active')
var _city = $('#select-city').attr('data-value')
var _classify = $('.combo-list-nav li').eq(1).attr('data-value')
var page = {
    hot: {
        page: 1,
        id: 'hot'
    },
    can: {
        page: 1,
        id: 'can'
    },
    site: {
        page: 1,
        id: 1
    },
    zoom: {
        page: 1,
        id: 2
    },
    activity: {
        page: 1,
        id: 4
    },
    service: {
        page: 1,
        id: 3
    },
    other: {
        page: 1,
        id: 5
    }
}
var send = {
    city_id: _city,
    cate_id: page[_classify].id,
    page: 1,

}
var lodingHtml = '<div class="weui-infinite-scroll"><div class="infinite-preloader"></div>正在加载...</div>'
var defaultData = function() {
    // ajax 
    $('.combo-list-body').find('#' + _classify).append($(lodingHtml))
    $.get('/api/combo/get_package_list', send, function(data) {
        if (data.errorno == 0) {
            var text = data.data;
            $('.combo-list-body').find('#' + _classify).find('.weui-infinite-scroll').remove()
            if (text.length == 0) {
                $(document.body).destroyInfinite()
            } else {
                $(document.body).infinite()
            }
            var html = ''
            $.each(text, function(i, k) {
                html += '<div class="combo-list-area clearfix">' +
                    '<div class="sale">' +
                    '<h6 class="tit">限时特惠价</h6>' +
                    '<em class="price f14"><small>￥' + k.price + '</small></em>' +
                    ' <del class="f12">¥' + k.marketPrice + '</del>' +
                    '</div>' +
                    '<div class="photo">' +
                    '<a href="/combo/detail/' + k.id + '">' +
                    '<img src="http://img.eventown.cn' + k.pic + '!nw554h332" alt=""></a>' +
                    '<div class="info"><span class="weui-col-70">' + k.tag + '</span>';
                if (k.position) {
                    html += '<span class="weui-col-30"><i class="iconfont f13">&#xe602;</i> ' + k.position + '</span>';
                } else {
                    html += '<span class="weui-col-30">' + k.position + '</span>';
                }
                html += '</div>' +
                    '</div>' +
                    '<h4><a href="/combo/detail/' + k.id + '" >' + k.title + '</a></h4>' +
                    '</div>';
            })
            $('.combo-list-body').find('#' + _classify).append(html)
            loading = false

        }

    })
};
/***定位***/
var map = new AMap.Map(""),
    lnglatXY;

function regeocoder(cb) { //逆地理编码
    var geocoder = new AMap.Geocoder({
        radius: 1000,
        extensions: "all"
    });
    geocoder.getAddress(lnglatXY, function(status, data) {
        if (status === 'complete' && data.info === 'OK') {
            var address = data.regeocode.addressComponent.city || data.regeocode.addressComponent.province;
            cb(address);
        }
    });
}

function getCityInfo(cb) {
    map.plugin('AMap.Geolocation', function() {
        geolocation = new AMap.Geolocation({
            enableHighAccuracy: true, //是否使用高精度定位，默认:true
            timeout: 10000, //超过10秒后停止定位，默认：无穷大
        });
        geolocation.getCurrentPosition();
        AMap.event.addListener(geolocation, 'complete', onComplete); //返回定位信息
    });
    //解析定位结果
    function onComplete(data) {
        lnglatXY = [data.position.getLng(), data.position.getLat()];
        regeocoder(cb)
    }
}
/***定位***/
//获取用户所在城市信息
// function getCityInfo(callback) {
//     var cityinfo;
//     //实例化城市查询类
//     var citysearch = new AMap.CitySearch();
//     //自动获取用户IP，返回当前城市
//     citysearch.getLocalCity(function(status, result) {
//         if (status === 'complete' && result.info === 'OK') {
//             if (result && result.city && result.bounds) {
//                 cityinfo = result.city
//                     //地图显示当前城市
//             }
//         } else {
//             cityinfo = '未知城市'
//         }
//         callback.call(null, cityinfo)
//         getCityInfo = function(callback) {
//             callback.call(null, cityinfo)
//         }
//     });
// }

getCityInfo(function(data) {
    if (data == '北京市') {
        send.city_id = 1;
        $('#select-city em').html('北京');
        $('#select-city').attr('data-value', send.city_id);
        $('.select-box li').eq(0).addClass('active')
        defaultData()
    } else if (data == '上海市') {
        send.city_id = 9;
        $('#select-city em').html('上海');
        $('#select-city').attr('data-value', send.city_id);
        $('.select-box li').eq(1).addClass('active')
        defaultData()
    } else if (data == '广州市') {
        send.city_id = 283;
        $('#select-city em').html('广州');
        $('#select-city').attr('data-value', send.city_id);
        $('.select-box li').eq(2).addClass('active')
        defaultData()
    } else if (data == '深圳市') {
        send.city_id = 285;
        $('#select-city em').html('深圳');
        $('#select-city').attr('data-value', send.city_id);
        $('.select-box li').eq(3).addClass('active')
        defaultData()
    } else {
        send.city_id = '';
        $('#select-city em').html('全部地区');
        $('#select-city').attr('data-value', send.city_id);
        $('.select-box li').eq(4).addClass('active');
        $('.combo-list-nav li').eq(0).show()
        $('.combo-list-nav li').removeClass('active');
        $('.combo-list-nav li').eq(0).addClass('active');
        $('.combo-list-body .tab-body').removeClass('active');
        $('.combo-list-body div.tab-body').eq(0).addClass('active');
        send.cate_id = 'hot';
        _classify = 'hot';
        defaultData()
    }
});
$(window).scroll(function() {
    var top = $(window).scrollTop();
    if (top > $('.combo-list-body').offset().top - 50) {
        $(".combo-list-nav").addClass('fixed');
    } else {
        $(".combo-list-nav").removeClass('fixed')
    }
});
$('.combo-list-nav').on('click', 'li', function() {
    _classify = $(this).attr('data-value')
    if ($(this).hasClass('active')) {} else {
        $(this).siblings().removeClass('active')
        $(this).addClass('active')
        $('.combo-list-body').find('.tab-body').removeClass('active')
        $('.combo-list-body').find('.tab-body').eq($(this).attr('data-index')).addClass('active')
        send.cate_id = page[$(this).attr('data-value')].id
        send.page = page[$(this).attr('data-value')].page
        console.log(send);
        var id = '#' + $(this).attr('data-value')
        if ($(this).parent().hasClass('')) {}
        if ($(id).html() === '') {
            defaultData()
        }
    }

})
$('.search-link').on('click', function() {
    $('.combo-list-head').addClass('search-show')
})
$('.combo-list-head').on('click', '.back', function() {
    $('.combo-list-head').removeClass('search-show')
})
$('#select-city').on('click', function() {
    $('.combo-list-head').removeClass('oh')
    $('.select-box').addClass('fadeInDown animated');
})
$('.select-box').on('click', 'li', function() {
    $.each(page, function(k, v) {
        page[k].page = 1;
        send.page = page[k].page
    })
    $('.combo-list-body div.tab-body').empty();
    if ($(this).find('a').attr('data-value') == '') {
        $('.combo-list-nav li').eq(0).show()
        $('.combo-list-nav li').removeClass('active');
        $('.combo-list-nav li').eq(0).addClass('active');
        $('.combo-list-body div.tab-body').eq(0).addClass('active');
        _classify = 'hot';
        send.cate_id = 'hot';
    } else {
        $('.combo-list-nav li').eq(0).hide()
        $('.combo-list-nav li').removeClass('active');
        $('.combo-list-nav li').eq(1).addClass('active');
        $('.combo-list-body div.tab-body').eq(1).addClass('active');
        _classify = 'can';
        send.cate_id = 'can';
    }
    // var Num = $(this).find('a').attr('data-value')
    $('.select-box li').removeClass('active')
    $(this).addClass('active')
    $(this).parent().removeClass('fadeInDown animated');
    $('#select-city em').html($(this).find('a').html())
    $('#select-city').attr('data-value', $(this).find('a').attr('data-value'))
    send.city_id = $('#select-city').attr('data-value');
    defaultData()

});

var loading = false; //状态标记
$(document.body).infinite(50).on("infinite", function() {
    if (loading) return;
    loading = true;
    page[_classify].page++;
    send.page = page[_classify].page;
    defaultData()
});
// 搜索
$('#search-btn').on('click', function() {
    var cityId = $('#select-city').attr('data-value')
    var cityVal = $(' #select-city em').html();
    var inputVal = $('.search-input').val()
    window.location.href = '/combo/combo_search?city_id=' + cityId + '&city_val=' + cityVal + '&key_words=' + inputVal
})


// 焦点图
var swiperData = function() {
    // ajax
    $.get('/api/combo/get_play_pic   ', function(data) {
        var text = data.data;
        var html = '';
        $.each(text, function(i, k) {
            html += '<div class="swiper-slide" data-index="' + i + '">' +
                '<a href=' + k.img_href + '  style="background-image:url(http://img.eventown.cn' + k.img + ')"></a></div>';
        })
        $(".swiper-container").find('.swiper-wrapper').html(html);
        var mySwiper = $('.swiper-container').swiper({
            mode: 'horizontal',
            pagination: '.swiper-pagination',
            loop: true,
            autoplay: 3000,
            observer: true, //修改swiper自己或子元素时，自动初始化swiper
            observeParents: true //修改swiper的父元素时，自动初始化swiper
        });
    });
};
swiperData();
defaultData();