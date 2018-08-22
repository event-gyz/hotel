// 百度地图
function getMap(CURRENT_PLACE){
    var start = new BMap.Point(CURRENT_PLACE.split(',')[1], CURRENT_PLACE.split(',')[0]);
    var map = new BMap.Map("placeMap");
    map.disableDoubleClickZoom()
    map.centerAndZoom(start, 13);
    map.enableScrollWheelZoom(true);
    map.disableDragging();
    var pointArr=CURRENT_PLACE.split(',');
    var point = new BMap.Point(pointArr[1], pointArr[0]);
    var typeArr=['较多','较少'];
    var bus=['便利','不便'];
    var doubleTrip={'bus':0};
    var doubleTrip={
        'bus':0,
        'shopping':0,
        'food':0,
        'happy':0,
        'trip':0
    };
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
    var local =  new BMap.LocalSearch(map, {renderOptions: {},onSearchComplete:function(results){
        if(results.keyword=='公交'){
            doubleTrip.bus=results.WA;
        }else if(results.keyword=='商场'){
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
};

function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}
var BH = $(window).height();
$('#app').height(BH);
$('.app-con').height(BH-50);
var VM=new Vue({
    el:'#app',
	data: {
        isMask: 'block',
        isShowHotelInt: false,
        roomMax: 0,
        serviceMax: 0,
        roomLimit: 3,
        serviceLimit: 5,
        serviceObj: [],
        info: {}
    },
    computed: {
        limitRoom: function(){
            if(Array.isArray(this.info['meetingrooms'])){
                this.roomMax = this.info['meetingrooms'].length;
                return this.info['meetingrooms'].slice(0,this.roomLimit);
            }
        },
        limitService: function(){
            var _this = this;
            if(Array.isArray(this.info['services'])){
                this.info['services'].forEach(function(item,index){
                    if(item.has){
                        item.show = true;
                    }
                    switch(item.key)
                        {
                            case 1:
                                item.code = '&#xe655;';//行李
                                break;
                            case 2:
                                item.code = '&#xe66b;';//商务
                                break;
                            case 3:
                                item.code = '&#xe658;';//出租车
                                break;
                            case 4:
                                item.code = '&#xe65b;';//免费停车
                                break;
                            case 5:
                                item.code = '&#xe650;';//WIFI
                                break;
                            case 6:
                                item.code = '&#xe65c;';//音箱
                                break;
                            case 7:
                                item.code = '&#xe652;';//引导牌
                                break;
                            case 8:
                                item.code = '&#xe64e;';//讲台
                                break;
                            case 9:
                                item.code = '&#xe64d;';//无线麦克
                                break;
                            case 10:
                                item.code = '&#xe662;';//投影仪
                                break;
                            case 11:
                                item.code = '&#xe63e;';//无柱会场
                                break;
                            case 12:
                                item.code = '&#xe754;';//温泉
                                break;
                            case 13:
                                item.code = '&#xe673;';//景区周边
                                break;
                            case 14:
                                item.code = '&#xe66a;';//园林草坪
                                break;
                            case 15:
                                item.code = '&#xe669;';//泳池
                                break;
                        }
                    _this.serviceObj.push(item);
                });
            }
            return this.serviceObj;
        }
    },
    mounted:function() {

            var that = this;
             $.get(api+'/place/get_place_detail',{place_id:GetQueryString("hotelid")}, function(data){
                     that.info=data.data;
                     getMap(data.data.location);
             })

    },
    updated: function(){
        this.isMask = 'none';
    },
    methods:{
        loadRoom: function(){
            if(this.roomLimit == 3){
                this.roomLimit = this.info['meetingrooms'].length;
            }else{
                this.roomLimit = 3;
            }
        },
        loadService: function(){
            this.isShowHotelInt = !this.isShowHotelInt;
        }
    }
});