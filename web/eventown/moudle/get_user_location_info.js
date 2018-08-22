/***百度地图获取城市 和 经纬度 
依赖     <script src="http://api.map.baidu.com/api?v=2.0&ak=ohLEV14RG2hiqGP1IKouKnT8"></script>
@getPosition
@getCityName
****/

(function(){

var LocationInfo = {
    getPosition: function(callback) {
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
               var location = r.point.lat + ',' + r.point.lng;
                callback && callback(null,location)
            } else {
                callback && callback('error',null)
                // ('获取定位失败' + this.getStatus());
            }
        }, { enableHighAccuracy: true })

    },
    getCityName: function(callback) {
        new BMap.LocalCity()
            .get(function(lcr) {
                callback && callback(lcr.name)
            })
    },
    convertCityNameToId: function(cityCache,lcrname) {
        var isSearch;
        $.each(cityCache, function(k, v) {
            if (lcrname.indexOf(v.name) > -1) {
                return v.name
            }
        })
    }
}

window.userLocationInfo=LocationInfo
})()

//百度地图获取城市 和 经纬度