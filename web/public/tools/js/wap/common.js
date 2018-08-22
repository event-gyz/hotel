
moment.locale('zh-cn');

Vue.filter('timestampFormat', function (timestamp, format) {
    var result;
    var  now = moment();
    timestamp =moment(parseInt(timestamp)*1000);

    console.log(timestamp.toString())

   var isToday=now.isSame(timestamp, 'day');  

   var isYesterday=now.isSame(timestamp.add(1, 'day'), 'day');
   var isSameYear=now.isSame(timestamp, 'year');  


    if (!timestamp){
        result = '-';
    } else if (format) {
        result = moment(timestamp).format(format);
    }else if(isToday){
       result ='今天'
    } 

    else if(isYesterday){
       result ='昨天'
    } 

    else if(isSameYear){
    	 result =timestamp.format('DD/MM')
    }

    else {
        result =timestamp.format('DD/MM/YYYY')
    }


    return result;
}
);



// var storage = window.localStorage;
// var local_token=storage.getItem("token");
$.extend($.ajaxSettings,{
	headers:{
		// token:local_token
    token:'McTxMpwhIpzIwMTYtOC0yMCAwOjA6MAO0O0OO0O0O'
	}
})

