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

//日期格式化
Vue.filter('formate', function(date) {

    var now = new Date(date);
    return (now.getFullYear() + '/' + parseInt(now.getMonth() + 1) + '/' + now.getDate())

})

//图片地址格式化
Vue.filter('fromatimg', function(value) {
     if((value.indexOf('upimg')>=0)||(value.indexOf('place')>=0)||(value.indexOf('meeting')>=0)||(value.indexOf('newimg')>=0)||(value.indexOf('pictrue')>=0)){
        return 'http://img.eventown.cn'+value+'!nw200h200';
     }else{
        return 'http://api.eventown.com'+value;
     }
})

Vue.filter('star', function(value) {
    var arr = '零一二三四五'.split('');
    return arr[value]
})




//全局参数对象
var param = {
        _city_id: 1,
        _city_name: '北京',
        _position: null,
        _room_price: '',
        _place_star: '',
        _page: 1,
        _location: '',
        _key_words: '',
        _from: 'room'
    },
    cityCache = [],
    user_location = '';

//获取用户位置

userLocationInfo.getPosition(function(err, data) {
    if (err) {
        return
    }
    user_location = data
})

var RoomListVM, placeArr = (function() {
    var lc = localStorage.getItem("placeList");
    if (lc != null && lc != '') {
        return rmRepeat(lc.split(','))
    } else {
        return []
    }
})()


Object.defineProperties(param, {
    city_id: {
        set: function(v) {
            this._city_id = v
            paramChange(v);
            getCityPositionInfoById(v)

        },
        enumerable: false,
        configurable: true
    },
    city_name: {
        set: function(v) {
            this._city_name = v;
            RoomListVM.city.name = v
        },
        enumerable: false,
        configurable: true
    },
    position: {
        set: function(newValue) {
            this._position = newValue
        },
        enumerable: false,
        configurable: true
    },
    room_price_num: {
        set: function(newValue) {
            this._room_price_num = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    place_star: {
        set: function(newValue) {
            this._place_star = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    location: {
        set: function(newValue) {
            this._location = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    key_words: {
        set: function(newValue) {
            this._key_words = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    }

})



getCityPositionInfoById(1)


function renderPositionInfo(res) {
    randorAreaChild('area_id', res.data)
    $('#area_tab_title').on('click.showContent', 'li', function() {
        var key = $(this).attr('data-name');
        randorAreaChild(key, res.data)
    })
}

//点击区域位置交互
function randorAreaChild(key, data) {
    var listData = data[key];
    var listHTML = ''

    if(listData.length > 0){
    $.each(listData, function(k, v) {
        listHTML += '<li forSearch="true" param-key="position"  param-value="' + key + '-' + v.id + '">' +
            '<i class="iconfont text-danger">&#xe61f;</i><a>' + v.name + '</a></li>'
    })
    }else{
        listHTML = "这个城市很穷"
    }

    $('#area_tab_content').html(listHTML)
}

$(document).on('click', '#area_tab_content li', function() {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        param._position = ''

    } else {

        $(this).addClass('active').siblings().removeClass('active')
        param._position = $(this).attr('param-value')
        param._location = ''
    }
})
$(document).on('click', '#area_tab_title li', function() {
        $(this).addClass('active').siblings().removeClass('active')
})
function getCityPositionInfoById(id) {
    getData('/api/place/get_search_param', { city_id: id })
        .then(renderPositionInfo)
}





function paramChange(v) {
    param._page = 1
    getPlaceData()
}


/******* 切换城市 ******/
$('#city').on('click', function(e) {
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
        param._location = ''
    param._position = ''
    param.city_id = $(this).attr('id');
    param.city_name = $(this).attr('name');
    $('.icon-back').trigger('click')
})


function getData(url, data) {
    var defer = $.Deferred();
    $.ajax({
        url: url,
        data: data,
        dataType: 'json',
        headers:{
            'Cache-Control': 'max-age=5300'
        },
        success: function(res) {
            if (res) {
                defer.resolve(res);
            } else {
                defer.reject();
            }
        },
        error: defer.reject
    });

    return defer.promise();
};
var error = function(e) {
        console.error('接口！！！！！获取数据失败' + e)
    }
    /***城市切换***/

var city_api = '/api/place/get_city_list';


function cacheCities(data) {
    for (var c in data) {
        Array.prototype.push.apply(cityCache, data[c]);
    }
    return cityCache
}


getData(city_api)
    .then(function(res) {
        if(res.data.abcd){
        renderCityList(res.data.abcd)
        cacheCities(res.data.abcd) 
        }else{
            console.error('加载城市失败,请检查城市接口')
        }
    }, error)


function renderCityList(data) {
    new Vue({
        el: '#cityContainer',
        data: {
            list: data
        }
    })
}







//数组去重
function rmRepeat(arr) {
    var obj = {},
        tmpArr = [];
    for (var i = arr.length - 1; i >= 0; i--) {
        if (!obj[arr[i]]) {
            obj[arr[i]] = true;
            tmpArr.push(arr[i])
        }

    }
    return tmpArr

}

function fomatDate(now) {
    return (now.getFullYear() + '/' + parseInt(now.getMonth() + 1) + '/' + now.getDate())
}



$('#date-input').on('change', function(e, val) {
    RoomListVM.dataInput = val
})

function renderPlaceList(data, next_page, city_center_location) {

    if (!RoomListVM) {
        RoomListVM = new Vue({
            el: 'body',
            data: {
                list: data,
                locationError: true,
                isNearby: false,
                dateInput: '',
                starRange: '',
                priceRange: '',
                keywords: '',
                next_page:next_page,
                city_center_location: city_center_location,
                city: {
                    id: 1,
                    name: '北京'
                }
            },
            computed: {
                has_next_page:function(){
                    if (parseInt(this.next_page)!=0 && parseInt(this.next_page) > param._page){
                    return true
                   }else{
                   return false
                 }
                },
                timeLong: function() {
                    return (new Date(this.dateInput.split('-')[1]) - new Date(this.dateInput.split('-')[0])) / 1000 / 60 / 60 / 24 || 1
                },
                userstartDate: function() {
                    if (this.dateInput) {
                        localStorage.mstarttime=this.dataInput.split('-')[0]
                        return this.dateInput.split('-')[0]
                    }else if(localStorage.mstarttime!=undefined){
                        return localStorage.mstarttime;
                    }
                    var sd = new Date().getTime();
                    sd += 1000 * 60 * 60 * 24;
                    localStorage.mstarttime=fomatDate(new Date(sd));
                    return fomatDate(new Date(sd))
                },
                userendDate: function() {
                    if (this.dateInput) {
                        localStorage.mendtime=this.dateInput.split('-')[1];
                        return this.dateInput.split('-')[1];
                    }else if(localStorage.mendtime!=undefined){
                        return localStorage.mendtime;
                    }
                    var d = new Date().getTime();
                    d +=(1000*60*60*24)*2;
                    localStorage.mendtime=fomatDate(new Date(d));
                    return fomatDate(new Date(d))
                },
            },
            methods: {
                getMore: function(el) {
                    param._page += 1
                    getPlaceData()
                },
                getNearby: function() {
                    this.city.name = '附近'
                    param._city_id = ''
                    param._position = '';
                    param.location = user_location
                },
                applyFilter: function() {
                    param._room_price = this.priceRange
                    param._place_star = this.starRange
                    paramChange()

                },
                cancelFilter: function() {
                    param._position = ''
                },
                search: function(el) {
                    var key_words = $.trim(this.keywords);
                    if (key_words == '' || key_words.length <= 0) {
                        return
                    } else {
                        param._location = ''
                        param.key_words = key_words
                    }
                }
            }
        })

    } else {
        RoomListVM.city_center_location = city_center_location

        if (param._page > 1) {
            RoomListVM.list = RoomListVM.$data.list.concat(data)
        } else {
            RoomListVM.list = data
            RoomListVM.next_page= next_page
        }
    }

}

//获取场地列表


function getPlaceData() {
    $('#loading').show()
    var postData = (function() {
        var o = {};
        for (var k in param) {
            if (param.hasOwnProperty(k)) {
                o[k.substring(1)] = param[k]
            }
        }
        return o
    })()

    getData('/api/place/get_place_list', postData)
        .then(function(res) {

            if (res.errorno == 0) {
                $('#loading').hide()
                renderPlaceList(res.data, res.next_page,res.city_center_location)
            }

        }, error)

}

getPlaceData()


// //搜索
$('#search-icon').on('click', function() {
    $('.header-default').hide()
    $('.search-bar').addClass('search-in')
})
$('.search-remove').on('click', function() {
    $('.header-default').show()
    $('.search-bar').removeClass('search-in')
    param._key_words = ''
})
