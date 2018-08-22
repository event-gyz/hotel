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
}
