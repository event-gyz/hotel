


var user_data={
	is_loading:true,
    message: '',
    true_name:'',
    avatar:'',
    time:''
  }

new Vue({
  el: '#vue_app',
  data:user_data
})

function quit(){
	$.fn.cookie('user_id', '0', { expires: -8, path:'/' , domain: '.eventown.com'});
  	$.fn.cookie('trace_sid','0',{  expires: -8, path:'/' , domain: '.eventown.com'});
  	$.toast('已退出登录，正在跳转...', 3000);
	setTimeout(function(){
	    window.location.href="/newweixin/login?to_url=%2Fpersonal%2Fcenter#login_code"
	},3000)
}


var storage = window.localStorage;
var token=storage.getItem("token") ;

if(!token){
	
	user_data.message='请先登录'

}else{



$.get('/newweixin/get_user_info',function(res){
	if(res.errorno==-1){
		$.fn.cookie('user_id', '0', { expires: -8, path:'/' , domain: '.eventown.com'});
	  	$.fn.cookie('trace_sid','0',{  expires: -8, path:'/' , domain: '.eventown.com'});
	  	$.toast(res.msg+'请重新登录，正在跳转...', 2000);
		setTimeout(function(){
		    window.location.href="/newweixin/login?to_url=%2Fpersonal%2Fcenter#login_code"
		},3000)
	}
	if(res.errorno==0){
	user_data.is_loading=false
	user_data.true_name=res.data.baseinfo.true_name;
	user_data.avatar=res.data.baseinfo.avatar;
	createVm()
		}
		else{
			$.alert(res.msg+'请重新登录')
		}

})

}

/*修改姓名**/

var saveName=function (true_name) {
	var n=$.trim(true_name);

	if(n=='' || n.length<2){
		$.alert('你的姓名这么短眻！');
		return 
	}

$.post('/newweixin/update_name',{true_name:true_name},function(res){

	if(res.errorno==0){
	    $.router.load('#main', true);
	    user_data.true_name=res.data.baseinfo.true_name
	}else{
		$.alert(res.msg+'请重新登录')
	}

})


}

function createVm () {
new Vue({
  el: '#modify_username',
  data:user_data,
  methods: {
  	submit:function(){
  		saveName(this.true_name)
  	}
  }

})
}






