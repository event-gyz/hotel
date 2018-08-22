<!DOCTYPE html>
<html lang="zh-cmn-Hans">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no, email=no" />
    <title>地图详情_会唐网</title>
    <link rel="stylesheet" href="/eventown/css/weui.css" />
    <link rel="stylesheet" href="/eventown/css/jquery-weui.css" />
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <style>
        .search{position:fixed; bottom:0px; left:0px; right:0px;}
        .search a{display:block; float:left; width:33.3%; padding:5px 0; line-height:25px; font-size:13px; text-align: center; color:#06c; background: #fff;}
        .btn-return{
          top:25px !important;
        }
    </style>
</head>
<body>
<div id="container">
    <div id="placeMap" style="width: 100%;height: 100%;"></div>
    <span class="btn-return"><a onclick="history.go(-1)"><i class="iconfont"></i></a></span>
    <!-- <div class="search">
        <a href="javascript:;" class="typeTrip"><i></i>附近地铁</a>
        <a href="javascript:;" class="typeShopping"><i></i>附近商场</a>
        <a href="javascript:;" class="typeBus"><i></i>附近公交</a>
    </div> -->
</div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8"></script>
<script type="text/javascript">
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
var MapInfo = GetRequest().location.split(",");

// 百度地图
var start = new BMap.Point(MapInfo[1], MapInfo[0]);
var map = new BMap.Map("placeMap");
map.centerAndZoom(start, 16);
map.enableDoubleClickZoom();

var marker = new BMap.Marker(start);  // 创建标注
map.addOverlay(marker);               // 将标注添加到地图中
marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画


// 复杂的自定义覆盖物
    function ComplexCustomOverlay(point, text){
      this._point = point;
      this._text = text;
    }
    ComplexCustomOverlay.prototype = new BMap.Overlay();
    ComplexCustomOverlay.prototype.initialize = function(map){
      this._map = map;
      var div = this._div = document.createElement("div");
      div.style.position = "absolute";
      div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
      div.style.backgroundColor = "#ffffff";
      div.style.border = "1px solid #ffffff";
      div.style.color = "black";
      div.style.padding = "5px 10px";
      div.style.lineHeight = "18px";
      div.style.whiteSpace = "nowrap";
      div.style.MozUserSelect = "none";
      div.style.fontSize = "12px";
      div.style.display='block';
      div.style.borderRadius='3px';
      div.style.width='12rem';
      var span = this._span = document.createElement("span");
      span.style.display='block';
      span.style.overflow='hidden';
      span.style.textOverflow='ellipsis';
      span.style.whiteSpace='nowrap';     
      div.appendChild(span);
      span.appendChild(document.createTextNode(this._text[0]));
      var span2 = this._span = document.createElement("span");
      span2.style.display='block';
      span2.style.overflow='hidden';
      span2.style.textOverflow='ellipsis';
      span2.style.whiteSpace='nowrap';
      div.appendChild(span2);
      span2.appendChild(document.createTextNode(this._text[1]));        
      var that = this;
      var arrow = this._arrow = document.createElement("div");
      arrow.style.background = "url(/public/images/jiantou.png) no-repeat";
      arrow.style.position = "absolute";
      arrow.style.width = "11px";
      arrow.style.height = "10px";
      arrow.style.top = "47px";
      arrow.style.left = "120px";
      arrow.style.overflow = "hidden";
      arrow.style.backgroundSize='contain';
      div.appendChild(arrow);
      map.getPanes().labelPane.appendChild(div);
      return div;
    }
    ComplexCustomOverlay.prototype.draw = function(){
      var map = this._map;
      var pixel = map.pointToOverlayPixel(this._point);
      this._div.style.left = pixel.x -8-parseInt(this._arrow.style.left) + "px";
      this._div.style.top  = pixel.y -80 + "px";
    }
// getAddress(start,function(){
    
// })
    var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(MapInfo[1], MapInfo[0]), [ GetRequest().hotelName,GetRequest().address]);

    map.addOverlay(myCompOverlay);
// map.addOverlay(createTxt(start));
// setSign();

function setSign(){
    var myIcon=createSign(start)
    var marker = new BMap.Marker(start,{icon:myIcon});
    map.addOverlay(marker);
}

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
</script>
</body>
</html>
