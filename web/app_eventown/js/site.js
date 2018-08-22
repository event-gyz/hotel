//图片地址格式化
Vue.filter('fromatimg', function(value) {
     if((value.indexOf('upimg')>=0)||(value.indexOf('place')>=0)||(value.indexOf('meeting')>=0)||(value.indexOf('newimg')>=0)||(value.indexOf('pictrue')>=0)){
        return 'http://img.eventown.cn'+value+'!nw200h200';
     }else{
        return 'http://api.eventown.com'+value;
     }
})


//vue filter 计算距离

Vue.filter('distance', function (value, user_location) {
//private const double EARTH_RADIUS = 6378.137;
if(!user_location ||  Math.abs( lat1 ) > 90   || Math.abs( lat2 ) > 90 || Math.abs( lng1 ) > 180   ||  Math.abs( lng2 ) > 180 ){
    return '未知'
}
function rad(d)
{
return d * Math.PI / 180.0;
}
  
var lat1=value.split(',')[0],  lng1=value.split(',')[1],  lat2=user_location.split(',')[0],  lng2=user_location.split(',')[1];

var radLat1 = rad(lat1);
var radLat2 = rad(lat2);
var a = radLat1 - radLat2;
var  b = rad(lng1) - rad(lng2);
var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a/2),2) +
Math.cos(radLat1)*Math.cos(radLat2)*Math.pow(Math.sin(b/2),2)));
s = s *6378.137 ;// EARTH_RADIUS;
s = Math.round(s * 10000) / 10000;
return s.toFixed(2);
})
// <span v-text="message | distance 'user_location' "></span>


//全局参数对象
var param = {
        _city_id: 1,
        _city_name: '北京',
        _position: 0,
        _place_type: 0,
        _place_people_num: 0,
        _place_star: 0,
        _activity: 0,
        _page: 1,
        _location:'',
        _key_words:''
    },
    cityCache = [],user_location='', tmpCity_id=param._city_id,tmpCity_name=param._city_name;

var PlaceListVM, placeArr =(function(){
    var lc=localStorage.getItem("placeList");
    if(lc!=null && lc !=''){
        return rmRepeat(lc.split(','))
    }else{
        return []
    }
})()

// param对象属性的操作
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
            $('#select-city').find('em').text(v)
        },
        enumerable: false,
        configurable: true
    },
    position: {
        set: function(newValue) {
            this._position = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    place_type: {
        set: function(newValue) {
            this._place_type = newValue
            localStorage.setItem("place_type", newValue);
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    place_people_num: {
        set: function(newValue) {
            this._place_people_num = newValue
            paramChange(newValue)
        },
        enumerable: false,
        configurable: true
    },
    activity: {
        set: function(newValue) {
            this._activity = newValue
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



//百度地图获取城市 和 经纬度

var user_location='';

var LocationInfo = {
    getPosition: function() {
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                // alert('您的位置：' + r.point.lng + ',' + r.point.lat);
                user_location = r.point.lat + ',' + r.point.lng;
              if(PlaceListVM) {
                PlaceListVM.locationError = false
                PlaceListVM.user_location = user_location
              }
            } else {
                if(PlaceListVM) { 
                    PlaceListVM.locationError=true;
                }
                console.log('获取定位失败' + this.getStatus());
            }
        }, { enableHighAccuracy: true })

    },
    getCityByBmap: function() {
        new BMap.LocalCity()
            .get(function(lcr) {
                LocationInfo.convertCityNameToId(lcr.name)
            })

    },
    convertCityNameToId: function(lcrname) {
        var isSearch;
        $.each(cityCache, function(k, v) {
            if (lcrname.indexOf(v.name) > -1) {
                getCityPositionInfoById(v.areaid);
                isSearch = true;
                return false
            }
        })
        if (!isSearch) {
            getCityPositionInfoById(1)
        }

    }
}

LocationInfo.getCityByBmap()

LocationInfo.getPosition()

function renderPositionInfo(res) {

    randorAreaChild('area_id', res.data)
    $('#area_tab_title').on('click.showContent', 'li', function() {
        var key = $(this).attr('data-name');
        randorAreaChild(key, res.data)
    })


}

function randorAreaChild(key, data) {
    var listData = data[key];

    var listHTML = ''
    $.each(listData, function(k, v) {
        listHTML += '<li forSearch="true" param-key="position"  param-value="' + key + '-' + v.id + '"><a>' + v.name + '</a></li>'
    })
    $('#area_tab_content').html(listHTML)
}

function getCityPositionInfoById(id) {
    getData('/api/place/get_search_param', { city_id: id })
        .then(renderPositionInfo)
}

function paramChange(v) {
    param._page = 1
    getPlaceData()
}


// 触发显示城市列表的按钮
$('#select-city').on('click', function(e) {
    $('#cityPage').show();
    $('#cityPage').offset().width = $('#cityPage').offset().width
    $('#cityPage').addClass('page-in')
})


//城市列表返回按钮
$('#cityPage').on('click', '.icon-back', function() {
    $('#cityPage').removeClass('page-in').on('transitionend', function() {
        $(this).hide();
        $(this).off('transitionend')
    })
});


//点击城市名称 切换城市
$('#cityPage').on('click', 'li.city', function() {
    param._location = ''
    param._position = ''
    tmpCity_id = param.city_id = $(this).attr('id')
    tmpCity_name = param.city_name = $(this).attr('name')
    $('.icon-back').trigger('click');
    $('li[data-name="#site"]').trigger('click')
})



function dropDown() {


    $('#more').on('click.dropdown', function(e) {
        e.preventDefault()
        e.stopPropagation()
        $('#moreInfo').show()
    })

    $(document).on('click.dropdown', function() {
        $('#moreInfo').hide()
    })

    //点击更多
    $('#moreInfo').on('click', 'li', function() {

        var lastIndex = 4 //菜单个数
        $(this).clone().css({
            opacity:0,
             marginLeft:'-100px'
        }).prependTo('#menu');
         $('#menu').find('.tab-title').get(0).offsetWidth =  $('#menu').find('.tab-title').get(0).offsetWidth
        $('#menu').find('.tab-title').eq(0).css({
            opacity:1,
            marginLeft:0
        }).trigger('click')
        $(this).remove();
        var last = $('#menu').find('.tab-title').eq(lastIndex);

        last.prependTo($('#moreInfo'))


    })


}

dropDown()


function menu_tab() {
    $('.filter-title ').on('click', 'li.tab-title', function() {

        $('#scrollBar').css({
            transform: 'translate3D(' + $(this).offset().left + 'px,0,0)'
        })


        $(this).addClass('active').siblings().removeClass('active')
        $('.select-area').hide();
        var target = $(this).attr('data-name');
        $(target).show()


        var key = $(this).attr('param-key');
        //如果点击的是“附近的”
        if(key==='location'){
            if(user_location==''){
               PlaceListVM.locationError=true
                return
            }
            PlaceListVM.isNearby=true
            PlaceListVM.locationError=false
            tmpCity_id = param._city_id;
            tmpCity_name = param._city_name;



            param._city_id=''
            param._city_name=''
            param._position=''
            param.location=user_location
             $('#select-city').find('em').text('附近')

        }
        //如果是区域 清空location
        else 
        {
            PlaceListVM.isNearby=false

        }



    })

    //子菜单

    $('.item-list').on('click', 'li', function() {
        var key = $(this).attr('param-key')
        var value = $(this).attr('param-value');

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            param[key] = 0
        } else {
            $(this).addClass('active').siblings().removeClass('active');
            if( key=='position')
            {
                param._location = ''
                param._city_id = tmpCity_id
                param._city_name = tmpCity_name
                 $('#select-city').find('em').text(tmpCity_name)
                PlaceListVM.isNearby=false
            }

            param[key] = value



        }
    })
}

menu_tab();

/*通用异步函数*/

/**
 * 获取数据
 *
 * @param  {Object} data 往后端发送的数据对象
 *
 * @return {Promise}      Promise
 */
function getData(url, data) {
    var defer = $.Deferred();
    $.ajax({
        url: url,
        data: data,
        dataType: 'json',
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
    console.error('接口！！！！！获取数据失败,盖飞快去查查。。' , e.responseURL)
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
        renderCityList(res.data.abcd)
        cacheCities(res.data.abcd)
    }, error);


function renderCityList(data) {
    new Vue({
        el: '#cityContainer',
        data: {
            list: data
        }
    })
}



$('#shopCartNum').text(placeArr.length)




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

function renderPlaceList(data,city_center_location) {
    //查找询单车id设置对应的场地btn 置灰色
    var placeArrStr=placeArr.join(',');
    $.each(data,function(k,v){
        if(placeArrStr.indexOf(v.place_id) > -1 ){
            v.disabled=true
        }
    })

    if (!PlaceListVM) {
        PlaceListVM = new Vue({
            el: '#vue_place_list_container',
            data: {
                list: data,
                locationError:true,
                isNearby:false,
                user_location:user_location,
                city_center_location:city_center_location
            },
            methods: {
                getMore: function(el) {
                    param._page += 1
                    getPlaceData()

                },
                addAskPrice: function(id, e) {
                    var el = e.currentTarget;
                    index = $.inArray(id+'', placeArr);
                    //已存在
                    if (index > -1) {
                        placeArr.splice(index, 1)

                    }else if( placeArr.length >= 5 ){
                        alert('最多添加5家哦')
                        return
                    }
                    //未存在
                    else {
                        placeArr.push(id+'');
                    }
                    localStorage.setItem("placeList", rmRepeat(placeArr));
                    $('#shopCartNum').text(placeArr.length).addClass('bounceIn');
                    setTimeout(function() {
                        $('#shopCartNum').removeClass('bounceIn');
                    }, 600)
                    $(el).toggleClass('active')


                }
            }
        })

    } else {
           PlaceListVM.city_center_location = city_center_location
           PlaceListVM.user_location = user_location

        if(param._page > 1){
            PlaceListVM.list = PlaceListVM.$data.list.concat(data)
        }else{
           PlaceListVM.list = data

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
                renderPlaceList(res.data,res.city_center_location)
            }

        }, error)
}

// getPlaceData()


function GetRequest() { 
    var url = decodeURI(location.search); //获取url中"?"符后的字串 
    var theRequest = new Object(); 
    if (url.indexOf("?") != -1) { 
      var str = url.substr(1); 
      strs = str.split("&"); 
      for(var i = 0; i < strs.length; i ++) { 
        theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]); 
      } 
    } 
    return theRequest; 
} 
var argu=GetRequest();
if(argu.city_id){
    for(var key in argu){
        param['_'+key]=argu[key];
    }
    
    $('#type li').each(function(){
        var pid=$(this).attr('param-value');
        if(pid==argu.place_type){
            $(this).addClass('active');
        }
    })

    $("#num li").each(function(){
        var num=$(this).attr('param-value');
        if(num==argu.place_people_num){
            $(this).addClass('active');
        }
    })

    if(argu.city_name!=''){
       $('#cityName').html(decodeURI(argu.city_name)); 
    }

    getPlaceData();
}else{
    getPlaceData();
}



//搜索

$('#JsearchBtn').on('click',function(){
   var key_words = $.trim($('input[type="search"]').val());
   if(key_words=='' || key_words.length<=0){
    return $('input[type="search"]').focus()
   }else{
    param._location=''
    param.key_words=key_words
   }

})

$('input[type="search"]').on('keyup',function(){
     var key_words = $.trim($('input[type="search"]').val());
   if(key_words=='' || key_words.length<=0){
        param._key_words = ''
   }

})


