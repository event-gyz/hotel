<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="format-detection" content="telephone=no, email=no" />
    <title>地图列表_会唐网</title>
    <link rel="stylesheet" href="/eventown/css/weui.css" />
    <link rel="stylesheet" href="/eventown/css/jquery-weui.css" />
    <link rel="stylesheet" href="/eventown/css/iconfont.css" />
    <link rel="stylesheet" href="/eventown/css/base.css" />
    <style>
        .search{position:fixed; bottom:0px; left:0px; right:0px;}
        .search a{display:block; float:left; width:33.3%; padding:5px 0; line-height:25px; font-size:13px; text-align: center; color:#06c; background: #fff;}
        .BMapLabel:after{
            content: " ";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 0;
            margin-left: -7px;
            border-style: solid;
            border-color: transparent;
            border-width: 7px;
            border-bottom-width: 0;
            z-index: 10;
        }
        .BMapLabel:after {
            border-top-color: #4895F2 ;
            margin-bottom: -6px;
        }
        .tselect:after{
            border-top-color: red ;
        }
        #list-map span{
            position: absolute;
            display: none;
            background:white;
            color: black;
            width: 7rem;
            padding: 0.3rem;
            text-align: center;
        }
        #list-map span p{
            overflow: hidden;
            text-overflow:ellipsis;
            white-space: nowrap;
            display: inline-block;
        }
        #list-map .linkname{
            font-size: 0.7rem;
            width: 100%;
            text-align: center;
        }
        #list-map .links{
            text-align: center;
        }
        #list-map .links a{
            color: #4895F2;
            border: 1px solid #dedede;
            display: inline-block;
            padding: 0.1rem;

        }
        #list-map span:after{
            content: " ";
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 0;
            height: 0;
            margin-left: -7px;
            border-style: solid;
            border-color: transparent;
            border-width: 7px;
            border-bottom-width: 0;
            z-index: 10;
            border-top-color: white ;
            margin-bottom: -6px;
        }
        .btn-return{
            top: 25px !important
        }
    </style>`
</head>
<script type="text/javascript">
      var data = <?= $locations?>;
</script>
<body>
<?php include VIEWPATH . 'webconfig/webconfig.php';?>
    <div id="container">
        <div id="map" style="width: 100%;height: 100%;"></div>
        <span class="btn-return"><a onclick="history.go(-1)"><i class="iconfont"></i></a></span>
    </div>
    <div id="list-map"></div>

</body>
</html>
<script id="list-template" type="text/x-handlebars-template">
    {{#each this}}
     <span class="tips{{@index}} maptip">
        <p class="linkname">{{place_name}}</p>
        <p class="links"><a href="{{url}}">查看详情</a></p>
     </span>
    {{/each}}
</script>
<script src="/public/hotel/js/jquery.js"></script>
<script type="text/javascript" src="http://links.eventown.com.cn/vendor/handlebars/handlebars.min.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8"></script>
<script type="text/javascript">
   getpostion();
    var place_geo_data=[];
    var PlaceMap = {
        markerArr: [], //点对象的集合。
        IMG_BASEURL: 'http://links.eventown.com.cn/images/icon/',
        mapDatalist: place_geo_data,
        index:10,
        //获取百度地图
        getBaiduMap: function() {    
            return new BMap.Map("map", { enableMapClick: false })
        },
        initMap: function() {
            this.map = this.getBaiduMap();
            this.mapDatalist=place_geo_data;
            var mapDatalist = this.mapDatalist || place_geo_data;
            if(mapDatalist.length==0)return;
            var point = new BMap.Point((mapDatalist[0].location.split(',')[1]),(mapDatalist[0].location.split(',')[0])) // 创建点坐标  
            if(data.current_location==undefined){
                this.map.centerAndZoom(point,15)  
            }
            this.map.addControl(new BMap.NavigationControl())
            this.map.addControl(new BMap.ScaleControl())
            this.map.addControl(new BMap.OverviewMapControl())
            this.map.enableScrollWheelZoom() //启动鼠标滚轮缩放地图
            this.randerMarker()
            this.map.addEventListener("dragstart", function(e){　
                　$('.maptip').hide();
                  $('.BMapLabel').css({'background':'#4895F2','border':'#4895F2'});
                  $('.BMapLabel').removeClass('tselect');
            });
   
            if(data.current_location!=undefined){
                var pt = new BMap.Point(data.current_location.split(',')[1],data.current_location.split(',')[0]);
                var myIcon = new BMap.Icon("/public/images/micon.png", new BMap.Size(40,50));
                var marker2 = new BMap.Marker(pt,{icon:myIcon});  // 创建标注
                this.map.addOverlay(marker2);
                this.map.centerAndZoom(pt,13) 
            }

        },
        randerMarker: function() {
            var mapDatalist = this.mapDatalist || place_geo_data;
            var points = [];
            var len = mapDatalist.length;
                //创建小狐狸
  
            for (var i = 0; i < len; i++) {
                var point = new BMap.Point(mapDatalist[i].location.split(',')[1], mapDatalist[i].location.split(',')[0]);
                var opts = {
                    position : point,    // 指定文本标注所在的地理位置
                    offset   : new BMap.Size(30, -30)    //设置文本偏移量
                  }
                var label = new BMap.Label("￥"+mapDatalist[i].price, opts);  // 创建文本标注对象
                label.setStyle({
                   color : "white",
                   background:'#4895F2',
                   fontSize : "12px",
                   height : "20px",
                   lineHeight : "20px",
                   fontFamily:"微软雅黑",
                   border:"1px solid #4895F2",
                   padding:'0 .3rem',
                   borderRadius:'2px'
                 });
                label.addEventListener("onclick", (function(label, i) {
                    return function() {
                        PlaceMap.showTips(label, i)
                    }
                })(label, i))
                points.push(point);
                this.map.addOverlay(label); // 将标注添加到地图中
            }
        },
        showTips: function(label, i) {
            $(".BMapLabel").css({'background':'#4895F2','border':'1px solid #4895F2'}).removeClass('tselect');
            $($(".BMapLabel")[i]).addClass('tselect');
            $(".maptip").hide();
            var tipsPos = PlaceMap.map.pointToPixel(label.getPosition());
            label.setStyle({
                background:"red",
                border : "1px solid red"
            })
            $('.tips' +i).show().css({ "top": tipsPos.y - 110, "left": tipsPos.x -20 })
        },
        removeLogo: function() {
            window.setTimeout(function() {
                if ($('.anchorBL').size() > 0) {
                    $('.anchorBL').hide()
                } else {
                    arguments.callee()
                }
            }, 100)
        }
    }
    function getpostion(){
      $.post(api_url+"/hotel/lists",{'location':data.clocation,'city_id':data.city_id,'city_name':data.city_name,'key_words':data.key_words,'star_rate':data.star_rate,'change_location':data.change_location
      ,'price':data.price,'roomMinPrice':data.roomMinPrice,'starSort':data.starSort,'position':data.position,'page':data.page},function (res) {
           place_geo_data=res.data.rows;
           var myTemplate = Handlebars.compile($("#list-template").html());
           $('#list-map').append(myTemplate(place_geo_data));
           PlaceMap.initMap();
       });
    }
    $('#list-map').on('click','.links a',function(){
        var href=$(this).attr('href');
        href=href+"&start_date="+data.start_date+"&end_date="+data.end_date;
        window.location.href=href;
        return false;
    })
</script>