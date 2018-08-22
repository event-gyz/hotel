//vue filter 计算距离

Vue.filter('distance', function(value, user_location) {
    //private const double EARTH_RADIUS = 6378.137;
    if (!user_location || Math.abs(lat1) > 90 || Math.abs(lat2) > 90 || Math.abs(lng1) > 180 || Math.abs(lng2) > 180) {
        return '未知'
    }

    function rad(d) {
        return d * Math.PI / 180.0;
    }

    var lat1 = value.split(',')[0],
        lng1 = value.split(',')[1],
        lat2 = user_location.split(',')[0],
        lng2 = user_location.split(',')[1];

    var radLat1 = rad(lat1);
    var radLat2 = rad(lat2);
    var a = radLat1 - radLat2;
    var b = rad(lng1) - rad(lng2);
    var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) +
        Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)));
    s = s * 6378.137; // EARTH_RADIUS;
    s = Math.round(s * 10000) / 10000;
    return s.toFixed(2);
})
//图片地址格式化
Vue.filter('fromatimg', function(value) {
     if((value.indexOf('upimg')>=0)||(value.indexOf('place')>=0)||(value.indexOf('meeting')>=0)||(value.indexOf('newimg')>=0)||(value.indexOf('pictrue')>=0)){
        return 'http://img.eventown.cn'+value+'!nw554h332';
     }else{
        return 'http://api.eventown.com'+value;
     }
})
//处理套餐图片地址
Vue.filter('comboimg', function(value) {
    return 'http://img.eventown.cn'+value+'!nw554h332';
})
//处理标签
Vue.filter('tagsplit', function(value) {
    var tagsplit = value.split(',');
    var str = '';
    for(var i=0;i<tagsplit.length;i++){
        str +="<span class='tag'>"+tagsplit[i]+"</span>";
    }
    return str;
})
//处理星级
Vue.filter('star', function(value) {
    var str = "<i class=\"iconfont\">&#xe60b;</i>";
    for (var i = 0; i < value-1; i++) {
        str+= "<i class=\"iconfont\">&#xe60b;</i>";
    };
    return str;
})

var miceList = (function() {

    function getData(data) {
        $.ajax({
            url: '/api/place/get_meeting_list',
            data: {city_name:data},
            dataType: 'json',
            headers:{
                'Cache-Control': 'max-age=5300'
            },
            success: function(res) {
                //$('#loading').hide();
                createVM(res.data)
            },
            error:function(){
                //$('#loading').hide();
                $.alert('加载失败，请尝试刷新！');
            }
        });


    }

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
    
    var cookie = {
        set:function(key,val,time){//设置cookie方法
            var date=new Date(); //获取当前时间
            var expiresDays=time;  //将date设置为n天以后的时间
            date.setTime(date.getTime()+expiresDays*24*3600*1000); //格式化为cookie识别的时间
            document.cookie=key + "=" + val +";expires="+date.toGMTString();  //设置cookie
        },
        get:function(key){//获取cookie方法
            /*获取cookie参数*/
            var getCookie = document.cookie.replace(/[ ]/g,"");  //获取cookie，并且将获得的cookie格式化，去掉空格字符
            var arrCookie = getCookie.split(";")  //将获得的cookie以"分号"为标识 将cookie保存到arrCookie的数组中
            var tips;  //声明变量tips
            for(var i=0;i<arrCookie.length;i++){   //使用for循环查找cookie中的tips变量
                var arr=arrCookie[i].split("=");   //将单条cookie用"等号"为标识，将单条cookie保存为arr数组
                if(key==arr[0]){  //匹配变量名称，其中arr[0]是指的cookie名称，如果该条变量为tips则执行判断语句中的赋值操作
                    tips=arr[1];   //将cookie的值赋给变量tips
                    break;   //终止for循环遍历
                } 
            }
            return tips;
            }
    }

    var city_name = cookie.get('city_name');
    if(!city_name){
        getCityInfo(function(data) {
                cookie.set('city_name',data,0.5);
            })
    }

    function createVM(data) {

        CartVM = new Vue({
            el: 'body',
            data: {
                list: data
            }
        })

    }

    return {
        init: function() {
            //$('#loading').show()
            getData(cookie.get('city_name'))
        }
    }
}())

miceList.init();
  
    $("#place_people_num").select({
        title: "活动人数",
        items: [{
            title: "不限",
            value: "0",
        }, {
            title: "10-50人",
            value: "1",
        }, {
            title: "50-100人",
            value: "2",
        }, {
            title: "100-300人",
            value: "3",
        }, {
            title: "300-500人",
            value: "4",
        }, {
            title: "500-1000人",
            value: "5",
        }, {
            title: "1000+人",
            value: "6",
        }]
    });
    // 
    $("#place_type").select({
        title: "场地类型",
        items: [{
            title: "不限",
            value: "0",
        }, {
            title: "酒店/度假村",
            value: "1",
        }, {
            title: "会议中心/展览馆/体育馆",
            value: "2",
        }, {
            title: "酒吧/餐厅/会所",
            value: "3",
        }, {
            title: "艺术中心/剧院",
            value: "4",
        }, {
            title: "其它",
            value: "5",
        }]
    })



$('#select-city').on('click', function(e) {
    $('#cityPage').show();
    $('#cityPage').offset().width = $('#cityPage').offset().width
    $('#cityPage').addClass('page-in')
})
$('#cityPage').on('click', '.icon-back', function() {
    $('#cityPage').removeClass('page-in').on('transitionend', function() {
        $(this).hide();
        $(this).off('transitionend')
    })
});
$('#cityPage').on('click', 'li.city', function() {
    var tmpCity_id = $(this).attr('id')
    var tmpCity_name = $(this).attr('name')
    $("#select-city").val(tmpCity_name);
    $("#select-city-id").val(tmpCity_id);
    $('.icon-back').trigger('click')
    $('li[data-name="#site"]').trigger('click')
})

function sendSearch(){
    var city_id = $('#select-city-id').val();
    var city_name = $('#select-city').val();
    var place_people_num = $('#place_people_num').attr('data-values');
    var place_type = $('#place_type').attr('data-values');
    window.location.href = '/place/search?city_id='+city_id+'&city_name='+city_name+'&place_people_num='+place_people_num+'&place_type='+place_type;
}

// 禁止焦点
$("input[readonly]").focus(function(){
         $(this).blur();
})



