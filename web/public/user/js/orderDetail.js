var user_id=$.fn.cookie('user_id');
var trace_sid=$.fn.cookie('trace_sid');
var url=encodeURI(window.location);
if(user_id==null || trace_sid==null){
  window.location.href=api_url+"/newweixin/login?to_url="+url+"#login_code"
}
function getId(){
	var arr=(window.location.href).split("?");
	var newarr=arr[1].split('=');
	return newarr[1];

}
function smap(location){
        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(location.split(',')[1],location.split(',')[0]), 15);
        map.disableDoubleClickZoom();
        map.enableScrollWheelZoom(true);
        map.disableDragging();
}
var VM=new Vue({
    el:'#app',
    data:{
    	isMask:'block',
    	info:{},
        location:'',
        priceList:[],
        cur_location:'',
    },
    mounted:function(){
    	var _this=this;
        $.ajax({ 
            url:api_url+"/order/get",
            type:"post",
            data: {"oid":getId()},
            xhrFields:{withCredentials:true},
            success:function(data){ 
               _this.info=data.data;
               _this.isMask='none';
               _this.location=data.data.location;
               _this.priceList=data.data.price_list;
               setTimeout(function(){
                 smap(_this.location);
               },300)
            }
        })
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                _this.cur_location = r.point.lat+','+r.point.lng;
            }
        }, { enableHighAccuracy: true });
    },
    methods:{
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
            window.location.href='/user/orderResults?orderid='+this.info.orderId+'&location='+this.location;
        },
        goback:function(){
            window.location.href=api_url+"/user/hotelOrder"
        },
        topay:function(orderId,h_id,c_id){
            window.location.href=api_url+"/pay/fast_yeepay?order_id="+orderId+"&h_id="+h_id+"&c_id="+c_id
        }
    },
    filters:{
		changeDate:function(value){
            return value.split('-')[1]+"月"+value.split('-')[2]+"日";
		}
	}
});









