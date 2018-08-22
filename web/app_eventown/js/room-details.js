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
    map.centerAndZoom(start, 13);
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
    $('.min-numbox').each(function() {
        var that = $(this)
        $(this).find('.numbox-plus').on('click', function() {
            that.find('.min-numbox-ant').addClass('min-numbox-in')
        })
        $(this).find('.numbox-minus').on('click', function() {
            that.find('.min-numbox-ant').removeClass('min-numbox-in');
        })
    })

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

function reckon(obj){
    var d=obj.wr;  
    var pointArr=[];
    if(d.length>0){
        for(var i=0,n=d.length; i<n; i++){
            var lng=d[i].point.lng,lat=d[i].point.lat;
            var point=new BMap.Point(lng,lat);
            var from=BMapLib.GeoUtils.getDistance(start, point);
            pointArr.push(from);
        }
        var min=pointArr.getMin().min;
        var results="<span style='position:absolute;background:url(/eventown/images/sjIcon.png) no-repeat center top; opacity:0.8; width:15px; top:-7px; color:#000; left:50%; margin-left:-7px'>&nbsp;</span>与最近的地铁相距<span style='font-weight:bold; font-size:14px;'>"+(min/1000).toFixed(2)+'</span>km';
        createTip(results);
        // console.log(pointArr,'====',pointArr.getMin());
    }
}

function createTip(str){
    var marker = new BMap.Marker(start);  // 创建标注
    map.addOverlay(marker);              // 将标注添加到地图中

    var label = new BMap.Label(str,{offset:new BMap.Size(-68,39)});
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
    reckon(results);
}});  
local.searchNearby('地铁',start,1500);

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
}())