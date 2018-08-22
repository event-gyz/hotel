/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */
var k = 0
$(document).on('ajaxError ', function(e, xhr, options) {
    // This gets fired for every Ajax request performed on the page.
    // The xhr object and $.ajax() options are available for editing.
    // Return false to cancel this request.
    console.error("服务器错误" + k++ + e + xhr + options);

})


$.getUrlParam = function(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    return null;
}
var shopId = $.getUrlParam('shop_id');

var getDataUtil = function(url, pram) {
    return new Promise(function(resolve, reject) {

        $.ajax({
            type: 'GET',
            url: url,
            data: pram,
            dataType: 'json',
            timeout: 3000,
            success: function(data) {
                resolve(data)
            },
            error: function(xhr, type) {
                reject(xhr)
            }
        })
    })
}

var saleSend = {
    shop_id: shopId,
    page: 1
};

var placeSend = {
    shop_id: shopId,
    page: 1
};

var getAjaxDataAll = (function() {
    function shop() {
        return getDataUtil('/api/shop/get_shop_info', { shop_id: shopId })
    }

    function sale() {
        return getDataUtil('/api/shop/get_special_offer', saleSend)
    }

    function place() {
        return getDataUtil('/api/shop/get_shop_place_info', placeSend)
    }

    var o = {
        shop: shop,
        sale: function() {
            sale().then(function(d) {
                saleData(d)
            })
        },
        palce: function() {
            place().then(function(d) {
                placeData(d)
            })
        },
        shop: function() {
            shop().then(function(d) {

                shopData(d)

            })
        }
    }

    o.sale();
    o.shop();
    o.palce();
    return o
})()

// 限时特惠

function saleData(res) {
    if (res.errorno == 0) {
        $('.shop-sale').find('.weui-infinite-scroll').remove()
        var text = res.data.list;
        if (res.data.page == 1 && text.length == 0) {
            delete saleSend.page

            $('.shop-sale').append('<div class="no_tips" ><img  class="no_pic" src="/eventown/images/ht_none.png" width="30%"  /> <p  algin="center"> 这家店铺没有上传特惠商品哦 </p>  <a href="/combo/combo_list" class="btn-danger-none">寻找会议套餐</a> </div>')
            $('#loading').hide();
            return
        }
        if (typeof text == 'undefined' || text.length == 0) {
            delete saleSend.page
            $('.shop-sale').append('<div  class="weui-infinite-scroll">没有更多了</div>')
            $('#loading').hide();
            return;
        }
        var html = ''
        $.each(text, function(i, k) {

            html += '<div class="shop-sale-list" onclick="javascript:window.location.href=\'/combo/detail/' + k.id + '\'">'
            html += '<div class="pic"><img src="' + k.pic_url + '!/both/100x100" ></div>'
            html += '<div class="info">'
            html += '<h3>' + k.title + '</h3>'
            html += '<div class="tag-group">'
            for (var i = k.combo_tag.length - 1; i >= 0; i--) {
                html += '<span class="tag">' + k.combo_tag[i].tag_name + '</span>'
            }
            html += '</div>'
            html += '<div class="details">'
            html += '<span class="price text-orange f20 f-l">¥' + k.unit_price + '</span>'
            html += '<span class="fl discount">' + k.discount + '折</span>'
            html += '<span class="text-info f-r"><i class="iconfont">&#xe602;</i>' + k.position + '</span>'
            html += '</div>'
            html += '</div>'
            html += '</div>'
        });

        $('.shop-sale').append($(html))
        loading = false
        $('#loading').hide();
        $('.img_text').show()

    }
}

// 场地
function placeData(res) {

    var html = ''
    var text = res.data.list;
    if (res.data.page == 1 && text.length == 0) {
        delete placeSend.page
        $('.shop-site').append('<div class="no_tips" ><img  class="no_pic" src="/eventown/images/ht_none.png" width="30%"  /> <p  algin="center"> 这家店铺没有上传场地哦 </p>  <a href="/newweixin/rfp" class="btn-danger-none">找个场地</a> </div>')
        $('#loading').hide();
        return
    }
    $('#loading').hide();
    $('.img_text').show()
    if (typeof text == 'undefined' || text.length == 0) {
        delete placeSend.page
        $('.shop-site').append('<div  class="weui-infinite-scroll">没有更多了</div>')
        return;
    }

    $.each(text, function(i, k) {

        var starGroup = ''
        for (var i = 0; i < k.star_rate; i++) {
            starGroup += '<i class="iconfont">&#xe60b;</i>'
        };
        html += '<div class="shop-site-list">' +
            '<a href="/place/detail/' + k.place_id + '"  class="site-link">' +
            '<div class="info">' +
            '<h3>' + k.place_name + '</h3>' +
            '<div class="star-group">' + starGroup + '</div>' +
            '<p class="details">最多容纳: <em class="text-yellow">' + k.max_num_arr + '</em> 人,' +
            '(最大会场面积' + k.max_area + '㎡）</p>' +
            '<p class="address">' + k.address + '</p>' +
            '</div>' +
            '</a>' +
            '<img src="' + k.img_url + '" >' +
            '</div>'
    });

    $('.shop-site').append($(html))
    loading = false
}

//店铺

function shopData(data) {
    var data = data.data;
	if(data.background){
		data.background = 'http://img.eventown.cn/'+ data.background;
	}else{
		data.background = 'http://www.eventown.com/images/banner_01.png';
	}
	data.avatar?data.avatar='http://img.eventown.cn/'+data.avatar:data.avatar='http://www.eventown.com/images/logo_hb.png';
	var html = '<div class="shop-head" style="background-size:100% 100%;background-image: url(' + data.background + ')">' +
        '<span class="btn-return"><a onclick="history.go(-1)"><i class="iconfont">&#xe605;</i></a></span>' +
        '<div class="shop_bg">' + '<div class="shop_top">' + '<div class="shop_logo">' +
        '<a><img src="' + data.avatar + '"></a>' + '</div>' +
        '<div class="shop_name">' + '<h2>' + data.shop_name + '</h2>' + '</div>' + '</div>' + '</div>' + '</div>'

    $('body').prepend($(html))
}

var tab = '#tab1';
$('.weui_navbar').on('click', 'a', function() {
    tab = $(this).attr('href');
    loading = false;
})

var loading = false; //状态标记
$(document.body).infinite(100).on("infinite", function() {
    if (loading) return;
    loading = true;
    if (tab == '#tab1' && typeof saleSend.page !== 'undefined') {
        saleSend.page++;
        $('#loading').show();
        getAjaxDataAll.sale();
    }
    if (tab == '#tab2' && typeof placeSend.page !== 'undefined') {
        placeSend.page++;
        $('#loading').show();
        getAjaxDataAll.palce();
    }
});
