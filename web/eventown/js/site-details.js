/**
 * 
 * @title --
 * @authors goodliang
 * @date 2015-11-26 19:35:08
 * 
 */

// 百度地图
var start = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0]);
var map = new BMap.Map("placeMap");
map.disableDoubleClickZoom()
map.centerAndZoom(start, 13);
map.enableScrollWheelZoom(true);
map.disableDragging(); 
// console.log('start', start);

// var marker = new BMap.Marker(start); // 创建标注
// map.addOverlay(marker); // 将标注添加到地图中
// marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画


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
Array.prototype.getMin=function(){
    min={'min':this[0],'index':0};
    for(var i=1; i<this.length; i++){
        if(min.min>this[i]){
            min.min=this[i];
            min.index=i;
        }
    }
    return min;
}

function getAddress(point,fn){
    var geoc = new BMap.Geocoder(); 
    geoc.getLocation(point, function(rs){
        var addComp = rs.addressComponents;
        fn(addComp);
    });
}

(function(){
    var pointArr=CURRENT_PLACE.split(',');
    var point = new BMap.Point(pointArr[1], pointArr[0]);
    getAddress(point,function(address){
        var str='http://map.baidu.com/mobile/webapp/search/search/qt=s&wd='+place_name+'&c=131&searchFlag=bigBox&version=5&wd2='+address.province+address.city+address.district+address.street+'&exptype=dep&src_from=webapp_all_bigbox&sug_forward=92bc1f0a948a5c38a0acc418&src=1/vt=map';
        // $('#bmapHref').attr('href',str);
    })
    var typeArr=['较多','较少'];
    var bus=['便利','不便'];
    var doubleTrip={'bus':0};

    var doubleTrip={
        'bus':0,
        'shopping':0,
        'food':0,
        'happy':0,
        'trip':0
    }
    Object.defineProperties(doubleTrip,{
        bus:{
            set:function(newValue){
                this._bus = newValue;
                doubleTripChange('bus');
            },
            enumerable: false,
            configurable: true
        },
        shopping:{
            set:function(newValue){
                this._shopping=newValue;
                doubleTripChange('shopping');
            }
        },
        food:{
            set:function(newValue) {
                this._food=newValue;
                doubleTripChange('food');
            }
        },
        happy:{
            set:function(newValue) {
                this._happy=newValue;
                doubleTripChange('happy');
            }
        },
        trip:{
            set:function(newValue) {
                this._trip=newValue;
                doubleTripChange('trip');
            }
        }
    });

    function doubleTripChange(name){
        for(var key in doubleTrip){
            if(key=='_food'){
                if(doubleTrip[key]>300){
                    $('#food').html(typeArr[0]).addClass('text-orange');
                }else{
                    $('#food').html(typeArr[1]).removeClass('text-orange');
                }
            }else if(key=='_happy'){
                if(doubleTrip[key]>300){
                    $('#happy').html(typeArr[0]).addClass('text-orange');
                }else{
                    $('#happy').html(typeArr[1]).removeClass('text-orange');
                }
            }else if(key=="_shopping"){
                if(doubleTrip[key]>20){
                    $('#shopping').html(typeArr[0]).addClass('text-orange');
                }else{
                    $('#shopping').html(typeArr[1]).removeClass('text-orange');
                }
            }else{
                if(doubleTrip._trip !=undefined && doubleTrip._bus !=undefined){
                    doubleTrip._trip=doubleTrip._trip?doubleTrip._trip:0;
                    var num=doubleTrip._trip+doubleTrip._bus;
                    if(num>20){
                        $('#busTrip').html(bus[0]).addClass('text-orange');
                    }else{
                        $('#busTrip').html(bus[1]).removeClass('text-orange');
                    }
                }
            }
        }
    }
   
    function reckon(obj){
        var resultArr=[],str;
        if(obj.wr){
            for(var i=0,n=obj.wr.length; i<n; i++){
                var lng=obj.wr[i].point.lng,lat=obj.wr[i].point.lat;
                var point=new BMap.Point(lng,lat);
                var from=BMapLib.GeoUtils.getDistance(start, point);
                resultArr.push(from);        
            }
            var min=resultArr.getMin();
            str="<span style='position:absolute;background:url(/eventown/images/sjIcon.png) no-repeat center top; opacity:0.8; width:15px; top:-7px; color:#000; left:50%; margin-left:-7px'>&nbsp;</span>与最近的地铁相距<span style='font-weight:bold; font-size:14px;'>"+(min.min/1000).toFixed(2)+'</span>km';
            createMark(str);
        }else{
            str="附近没有地铁";
        }
    }

    function createMark(str){
        var marker = new BMap.Marker(start);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中

        var label = new BMap.Label(str,{offset:new BMap.Size(-72,39)});
        label.setStyle({
             color : "#fff",
             fontSize : "12px",
             padding:'5px 10px',
             height : "20px",
             border:'none',
             boxShadow: '2px 2px 2px 0 #ccc',
             zIndex:'2',
             background:'rgba(237,45,45,0.8)',
             borderRadius:'4px',
             position:'relative',
             lineHeight : "20px",
             fontFamily:"微软雅黑"
         });
        marker.setLabel(label);
    }

    var local =  new BMap.LocalSearch(map, {renderOptions: {},onSearchComplete:function(results){
        if(results.keyword=='公交'){
            // console.log(results.WA
            doubleTrip.bus=results.WA;
        }else if(results.keyword=='地铁'){
            reckon(results);
            doubleTrip.trip=results.WA;
        }else if(results.keyword=='商场'){
            // doubleTrip.push({'keyword':results.keyword,'num':results.WA});
            doubleTrip.shopping=results.WA;
        }else if(results.keyword=='餐饮'){
            doubleTrip.food=results.WA;
        }else if(results.keyword=='娱乐'){
            doubleTrip.happy=results.WA;
        }
    }});  
    local.searchNearby('餐饮',start,1500);
    local.searchNearby('商场',start,1500);
    local.searchNearby('娱乐',start,1500);
    local.searchNearby('公交',start,1500);
    local.searchNearby('地铁',start,1500);

}())

// 表格展开收起
$('.table-box').each(function() {
    var decLeng = $(this).find('tr').length
    var btnMore = $(this).find('.more-box')
    var decHide = $(this).find('tr:nth-child(n+5)')
    if (decLeng > 3) {
        btnMore.show()
        decHide.addClass('hide');
    } else {
        btnMore.hide();
    }
    btnMore.click(function() {
        var fold = $(this).attr('data-state')
        decHide.toggleClass('hide');
        if ($(this).attr('data-state') === 'open') {
            console.log('open');
            $(this).find('a').html('收起全部 <i class="icon iconfont">&#xe60f;</i>')
            $(this).attr('data-state', 'colse')
        } else {
            $(this).find('a').html('展开全部 <i class="icon iconfont">&#xe610;</i>')
            $(this).attr('data-state', 'open')
        }
    })
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