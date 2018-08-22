var user_id=$.fn.cookie('user_id');
var trace_sid=$.fn.cookie('trace_sid');
if(user_id==null || trace_sid==null){
  window.location.href=api+"/newweixin/login?to_url=http%3A%2F%2Fdev.mobile.eventown.com%2Fuser%2FhotelOrder#login_code"
}
var VM=new Vue({
	el:'#app',
	data:{
		allOrder:[],
	  selected:1,
	  isMask:'block',
    page:1,
    ismore:true,
    cur_location:''
	},
	mounted:function(){
        var _this=this;
        var arr=window.location.search.substr(1),value;
        arr=="" ? value=1 : value=arr.split('=')[1]; 
        this.getDate(value);
        this.selected=value;
        var geolocation = new BMap.Geolocation();
        geolocation.getCurrentPosition(function(r) {
            if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                _this.cur_location = r.point.lat+','+r.point.lng;
            }
        }, { enableHighAccuracy: true });
	},
	methods:{
        selectedStatus:function(value){
           this.page=1;
           this.allOrder.splice(0,this.allOrder.length);
           this.selected=value;
           this.getDate(this.selected);
           this.isMask='block';
        },
        getDate:function(value){
        	var _this=this;
        	if(value==="" || value==1 || value==undefined){
        		value="";
        	}

          $.ajax({ 
                url:api_url+"/order/lists",
                type:"post",
                data: {'status':value,'page':_this.page},
                xhrFields:{withCredentials:true},
                success:function(data){ 
                   _this.ismore=data.data.all.length<10 ? false : true;
                   for(var i=0;i<data.data.all.length;i++){
                    _this.allOrder.push(data.data.all[i])
                   }
                   _this.isMask='none';
                }
          })
        },
        topay:function(order_id,h_id,c_id){
           window.location.href=api_url+"/pay/fast_yeepay?order_id="+order_id+"&h_id="+h_id+"&c_id="+c_id;
        },
        golink:function(id){
            window.location.href="/user/hotelOrderDetail?id="+id;
        },
        delete:function(){
           alert('此接口暂时还没有')
        },
        more:function(){
            this.page++;
            this.getDate(this.selected);
        }
	},
	filters:{
		changeDate:function(value){
          return value.split('-')[1]+"月"+value.split('-')[2]+"日";
		}
	}
})