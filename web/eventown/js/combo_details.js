/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */




var onOff = true;
var decLeng = $('.decoration-wrap .decoration-content').length
var decHide = $('.decoration-wrap .decoration-content:nth-child(n+5)')
if (decLeng > 3) {
    $('.decoration-more').show()
    decHide.addClass('hide')
} else {
    $('.decoration-more').hide()
}
$(".decoration-more").click(function() {
    decHide.toggleClass('hide');
    if (onOff) {
        $(this).find('a').html('收起更多会场 <i class="icon iconfont">&#xe60f;</i>')
        onOff = false
    } else {
        $(this).find('a').html('展开更多会场 <i class="icon iconfont">&#xe610;</i>')
        onOff = true
    }
})
$('.decoration-wrap .decoration-content').each(function(i) {
    $(this).on("click", function() {
        $.alert($(this).find('.decoration-box').html(), "桌型摆设");
    });
})

//预定份数
var minStart = $('#minStart').text();
var maxEnd = $('#maxEnd').text();
$('#btn-reduce').click(function() {
    //--
    var reduce = parseInt($('#tb_text').val());
    reduce--;
    if (reduce < minStart) {
        $.toast('份数超出范围', "text");
        return false;
    } else {
        $('#tb_text').val(reduce);
    }
})
$('#btn-add').click(function() {
    var add = parseInt($('#tb_text').val());
    add++;
    if (add > maxEnd) {
        $.toast('份数超出范围', "text");
        return false;
    } else {
        $('#tb_text').val(add);
    }
})
$('#purchase').click(function() {
    var tbNum = parseInt($('#tb_text').val());

    if (!isNaN(tbNum)) {
        if (tbNum < minStart) {
            $.toast('不能小于起订份数', "text")
            $('#tb_text').val(minStart);
            return false;
        }
        if (tbNum > maxEnd) {
            $.toast('不能大于上限份数', "text")
            $('#tb_text').val(maxEnd);
            return false;
        }
    } else {
        $.toast('请输入有效数字', "text");
        $('#tb_text').val(minStart);
        return false;
    }
    $('#number-info').html('已选数量：' + tbNum + '份')

});
// 图片浏览
var slideInfo = []
$('.slideshow .swiper-slide').each(function(i) {
    slideInfo.push({
        image: $(this).find('img').attr("src"),
        caption: $(this).find('span').html()
    });
})
$('.slideshow').on('click', '.swiper-slide', function() {
    var Num = $(this).attr('data-index')
    var hotelPhoto = $.photoBrowser({
        items: slideInfo,
        initIndex: Num
    });
    hotelPhoto.open();
})


// var loading = false;
// if( $('#container').height()<$('.combo-subTitle').offset().top){
//     $('#container').infinite(100).on("infinite", function() {
//         if (loading) return;
//         loading = true;
//         setTimeout(function() {
//             $('#loadingBar').hide()
//             $(".hide-body").show()
//             $(".go-top").show()
//             $(".fix-subNav").addClass('fixed');
//             $("#container").scrollTo($('#floor1').offset().top + $('#container').scrollTop() + 5);
//             loading = false;
//         }, 1000); //模拟延迟
//         $(this).destroyInfinite()
//     });
// }else {
//     $('#loadingBar').hide()
//     $(".hide-body").show()
// }


$('#container').scroll(function() {
    var top = $('#container').scrollTop();
    if (top > $('#floor1').offset().top + $('#container').scrollTop() - 50) {
        $(".fix-subNav").addClass('fixed');
    } else {
        $(".fix-subNav").removeClass('fixed')
    }
});


var oNav = $('.fix-subNav'); //导航壳
var aNav = oNav.find('li'); //导航
var aDiv = $('.hide-body .floor'); //楼层

//回到顶部
$('#container').scroll(function() {
        var winH = $(window).height(); //可视窗口高度
        var iTop = $(window).scrollTop(); //鼠标滚动的距离
        //鼠标滑动式改变  
        aDiv.each(function() {
            if (winH + iTop - $(this).offset().top > winH / 2 + 50) {
                aNav.removeClass('active');
                aNav.eq($(this).index() - 1).addClass('active');
            }
        })
    })
    //点击回到当前楼层
aNav.click(function() {
    var t = aDiv.eq($(this).index()).offset().top;
    // $("#container").scrollTo(t + $('#container').scrollTop() - 85);
    $(this).addClass('active').siblings().removeClass('active');
});


(function($) {
    $.extend($.fn, {
        scrollTo: function(m) {
            var n = 0,
                timer = null,
                that = this;
            var smoothScroll = function(m) {
                var per = Math.round(m / 50);
                n = n + per;
                if (n > m) {
                    window.clearInterval(timer);
                    return false;
                }
                that.scrollTop(n);
            };
            timer = window.setInterval(function() {
                smoothScroll(m);
            }, 5);
        }
    })
})(Zepto)

//幻灯片

$(".swiper-container").swiper({
    loop: true,
    // autoplay: 3000,
    paginationType: 'fraction',
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
    pagination: '.swiper-pagination'
});



// 联系商家
$('#cartBar').on('click', '#contact-shop', function() {

    $.modal({
        title: "联系方式",
        text: $('.tel-box').html(),
        buttons: [{
            text: "",
            className: "hide"
        }],

    });
})


// 百度地图
var start = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0]);
var map = new BMap.Map("placeMap");
map.centerAndZoom(start, 13);
map.disableDragging();
map.enableScrollWheelZoom(true);
// console.log('start', start);

var marker = new BMap.Marker(start); // 创建标注
map.addOverlay(marker); // 将标注添加到地图中
marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画


var routePolicy = [BMAP_DRIVING_POLICY_LEAST_TIME, BMAP_DRIVING_POLICY_LEAST_DISTANCE, BMAP_DRIVING_POLICY_AVOID_HIGHWAYS];

function draw(end) {
    map.clearOverlays();
    var driving = new BMap.DrivingRoute(map, {
        renderOptions: {
            map: map,
            autoViewport: true
        },
        policy: routePolicy[1]
    });
    driving.search(start, end);
}
