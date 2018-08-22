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
var VM=new Vue({
    el:'#app',
    data:{
        nearHotel:[],
        info:{},
        isMask:'block',
        cur_location:'',

    },
    mounted:function(){
        this.info.orderid=GetRequest().orderid;
        this.info.location=GetRequest().location;
        this.NearHotelFn();
        this.canCel();
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                _this.cur_location = r.point.lat+','+r.point.lng;
            }
        }, { enableHighAccuracy: true });
    },
    methods:{
        canCel:function(){
            var _this=this;
            $.ajax({ 
                    url:api_url+"/order/cancel",
                    type:"post",
                    data: {"oid":_this.info.orderid},
                    xhrFields:{withCredentials:true},
                    success:function(data){ 
                        if(data.errorno==0){
                            _this.info.hotel_name=data.data.hotel_name;
                            _this.info.orderNumber=data.data.order_no;
                            _this.info.url=data.data.url;
                            _this.info.orderid=data.data.order_id;
                            _this.info.time=data.data.create_time; 
                        }else{
                            alert(data.msg)
                        }
                        _this.isMask='none';
                    }
            }) 
        },
        popup:function(){
        	 $("#orderdetail").popup();    
        },
        closepop:function(){
             $("#orderdetail").hide(); 
        },
        gomap:function(){
            window.location.href="/hotel/map?location="+location.split(',')[1]+","+location.split(',')[0];
        },
        goCancel:function(){
            window.location.href='/user/orderResults?orderid='+this.info.orderId+'&orderNumber='+this.info.orderNumber+'&hotel_name='+this.info.hotel_name+'&hotelId='+this.info.hotelId;
        },
        //周边酒店
        NearHotelFn: function(){
            var _this=this;
            $.ajax({ 
                    url:api_url+"/hotel/get_similar_hotels",
                    type:"post",
                    data: {"location":_this.info.location},
                    success:function(data){ 
                         _this.nearHotel=data.data.rows;
                    }
            }) 

        },
    },
    filters:{
		changeDate:function(value){
            return value.split('-')[1]+"月"+value.split('-')[2]+"日";
		}
	}
});









