
moment.locale('zh-cn');

//图片地址格式化
Vue.filter('fromatimg', function(value) {
    if(value == null){
      return 'http://img.eventown.cn'+value+'!nw554h332';
    }
    if((value.indexOf('upimg')>=0)||(value.indexOf('place')>=0)||(value.indexOf('meeting')>=0)||(value.indexOf('newimg')>=0)||(value.indexOf('pictrue')>=0)){
            return 'http://img.eventown.cn'+value+'!nw554h332';
    }else{
        return 'http://api.eventown.com'+value;
    }
})

Vue.filter('timestampFormat', function (timestamp, format) {
    var result;

    if(isNaN(parseInt(timestamp))){
        result =''
    }

    var  now = moment();
   var  timestamp1 = moment(parseInt(timestamp)*1000);
   var  timestamp2 =moment(parseInt(timestamp)*1000);




   var isToday=now.isSame(timestamp1, 'day');  

   var isYesterday=now.isSame(timestamp2.add(1, 'day'), 'day');
   var isSameYear=now.isSame(timestamp1, 'year');  


    if (!timestamp1){
        result = '-';
    } else if (format) {
        result = moment(timestamp1).format(format);
    }else if(isToday){
       result ='今天'
    } 

    else if(isYesterday){
       result ='昨天'
    } 

    else if(isSameYear){
    	 result =timestamp1.format('DD/MM')
    }

    else {
        result =timestamp1.format('DD/MM/YYYY')
    }


    return result;
}
);


var storage = window.localStorage;
var local_token=storage.getItem("token");
var local_openid=storage.getItem("openid");
var local_unionid=storage.getItem("unionid");


// console.log('commonjs local_token',local_token)
$.extend($.ajaxSettings,{
	headers:{
		// token:local_token
    token:local_token,
    openid:local_openid,
    unionid:local_unionid
	}
})

