


var user_data={
	is_loading:true,
    message: '',
    true_name:'',
    avatar:'',
    time:'960616861'
  }

new Vue({
  el: '#vue_app',
  data:user_data
})




var storage = window.localStorage;
var token=storage.getItem("token") ;

if(token){
	
	user_data.message='请先登录'

}else{



$.get('/newweixin/get_user_info',function(res){
	user_data.is_loading=false
	user_data.true_name=res.data.baseinfo.true_name;
	user_data.avatar=res.data.baseinfo.avatar;
	createVm()
})

}

/*修改姓名**/


var saveName=(true_name)=>{
	let n=$.trim(true_name);

	if(n=='' || n.length<2){
		$.alert('你的姓名这么短眻！');
		return 
	}

$.post('/newweixin/update_name',{true_name:true_name},(res)=>{

	if(res.errorno==0){
	    $.router.load('#main', true);
	    user_data.true_name=res.data.baseinfo.true_name


	}else{
		$.alert(res.msg)
	}

})


}

var createVm=()=>{
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







