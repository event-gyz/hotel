/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */



function GetRequest() {
    var url = decodeURI(location.search); //获取url中"?"符后的字串 
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}
var id = GetRequest();

$('#select-city em').html(id.city_val)
$('#select-city').attr('data-value', id.city_id)
$('.search-input').val(id.key_words)

var send = {
    city_id: id.city_id,
    key_words: id.key_words,
    is_order: '',
    cate_id: '',
    page: 1
}
var hotSend = {
    city_id: '',
    cate_id: 'hot',
    page: 1,
    num: 9
}


var hotData = function() {
    // ajax
    $.get('/api/combo/get_package_list', hotSend, function(data) {
        var text = data.data;
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
        $('.search-hot').append(html)
    })
};
hotData();
var lodingHtml = '<div class="weui-infinite-scroll"><div class="infinite-preloader"></div>正在加载...</div>'
var defaultData = function() {
    // ajax
    $('.combo-list-body').append($(lodingHtml))
    $.get('/api/combo/get_package_list', send, function(data) {
        $('.combo-list-body').find('.weui-infinite-scroll').remove()
        var text = data.data;
        if (text.length == 0 && send.page == 1) {
            $('.search-null-body').show()
        } else {
            $('.search-null-body').hide()
        };
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
        $('.combo-list-body').append(html);
        loading = false;

    })
};
defaultData()
$(function() {
    $('#select-city').on('click', function() {
        $('.select-box').removeClass('fadeInDown animated')
        $('.city-list').addClass('fadeInDown animated');
    })
    $('.city-list').on('click', 'li', function() {
        $('.city-list li').removeClass('active')
        $(this).addClass('active')
        $(this).parent().removeClass('fadeInDown animated');
        $('#select-city em').html($(this).find('a').html())
        $('#select-city').attr('data-value', $(this).find('a').attr('data-value'))
    })
    $('.combo-list-filter .filter').on('click', function() {
        $(this).parent().removeClass('active')
        $(this).parent().addClass('active')
        $('.select-box').removeClass('fadeInDown animated')
        $(this).siblings('.select-box').addClass('fadeInDown animated');
    });
    $('.select-box').on('click', 'li', function() {
        $('.select-box').removeClass('fadeInDown animated')
        var head = $(this).children('a')
        $(this).siblings().removeClass('active')
        $(this).addClass('active')
        $(this).parent().siblings('.filter').html(head.html())
        $(this).parent().siblings('.filter').attr('data-value', head.attr('data-value'));
        send.is_order = $('#sort').attr('data-value');
        send.cate_id = $('#classify').attr('data-value');
        send.page = 1;
        if (!$(this).parent().hasClass('city-list')) {
            $('.combo-list-body').empty();
            if ($('.combo-list-body').html() === '') {
                defaultData()
            }
        }

    })
});
// $(function() {
//     var h1 = $('.combo-list-head').height()
//     var ss = $(window).scrollTop();
//     $(window).scroll(function() {
//         var s = $(window).scrollTop();
//         if (s > h1) {
//             $('.combo-list-head').addClass('gizle');
//             if (s > ss) {
//                 $('.combo-list-head').removeClass('sabit');
//             } else {
//                 $('.combo-list-head').addClass('sabit');
//             }
//             ss = s;
//         }
//     });
// });


var loading = false;
$(document.body).infinite(50).on("infinite", function() {
    if (loading) return;
    loading = true;
    send.page++;
    defaultData()
});

// 搜索
$('#search-btn').on('click', function() {
    send.city_id = $('#select-city').attr('data-value')
    send.key_words = $('.search-input').val();
    send.page = 1;
    $('.combo-list-body').empty();
    defaultData()
})
