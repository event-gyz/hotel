var storage = window.localStorage;
var local_openid=storage.getItem("openid");
var local_unionid=storage.getItem("unionid");


// console.log('commonjs local_token',local_token)
$.extend($.ajaxSettings,{
	headers:{
		// token:local_token
    openid:local_openid,
    unionid:local_unionid
	}
})

  var changeM_phone='';
// 验证手机号
function checkedP(obj){
	var val=obj.find('.phoneNum').val();
	var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
	return mobile.test(val);
}
// 验证密码
function checkedPassword(obj,Nclass){
	var val=obj.find(Nclass).val();
	if(val == ''){
		return false;
	}else if(val.length<6){
		return false;
	}else if(val.length>31){
		return false;
	}else{
		return true;
	}
}
// 倒计时
var timer=null;
function dTime(obj){
	var num=120;
	clearInterval(timer);
	obj.attr('disabled','true');
	timer=setInterval(function(){
		if(num==0){
			clearInterval(timer);
			obj.html('<span>重新获取验证码</span>');
			obj.removeAttr('disabled','true');
		}else{
			num--;
			obj.find('span').html(num+'s');
		}
	},1000)
}
// 验证验证码
function checkedC(obj){
	var val=obj.find('.getCode').val();
	if(val == ''){
		return false;
	}else if(val.length!=6){
		return false;
	}else if(isNaN(val)){
		return false;
	}else{
		return true;
	}
}

//登录
$('.login').click(function(){
	$(this).attr('disabled','true');
	var phone='',pws='',code="";
	if(!checkedP($(this).parent('.phoneBox'))){
		$.alert('请输入正确的手机号');
		$(this).removeAttr('disabled');
		return false;
	}
	var phone=$(this).parents('.phoneBox').find(".phoneNum").val();
	if($(this).parents('.phoneBox').find('.password').length>0){
		if(!checkedPassword($(this).parents('.phoneBox'),'.password')){
			$.alert('请输入正确的6-31位密码');
			$(this).removeAttr('disabled');
			return false;
		}
		pws=$(this).parents('.phoneBox').find('.password').val();
	}
	if($(this).parents('.phoneBox').find('.getCode').length>0){
		if(!checkedC($(this).parents('.phoneBox'))){
			$.alert('请输入正确的6位验证码');
			$(this).removeAttr('disabled');
			return false;
		}
		code=$(this).parents('.phoneBox').find('.getCode').val();
	}
	var _this=$(this);
	//验证码登录
	if(code){
		$.post('/newweixin/verification_code_login',{'mobile':phone,'verification_code':code},function(data){
			if(data.data && typeof data.data.token  ==  'undefined'){
				$.alert('帐号或密错误，请重试');
				_this.removeAttr('disabled');
				return false;
			}
			var url=data.url;
			if(data.errorno!=0){
				$.alert(data.msg);
				_this.removeAttr('disabled');
				return false;
			}else{
				do_login(data)
			}

		})
	}else{
		$.post('/newweixin/user_login',{'mobile':phone,'pwd':pws},function(data){
			if(data.data && typeof data.data.token  ==  'undefined'){
				$.alert('帐号或密码错误，请重试');
				_this.removeAttr('disabled');
				return false;
			}
			var token=data.data.token;
			var url=data.data.url;
			if(data.errorno!=0){
				$.alert(data.msg);
				_this.removeAttr('disabled');
				return false;
			}else{
			  do_login(data)
			}

		})
	}
	
})


  function do_login(data){

  		window.localStorage.setItem('token',data.data.token);
  		window.localStorage.setItem('openid',data.data.openid);
  		window.localStorage.setItem('unionid',data.data.unionid);
		$.toast('登录成功，正在跳转...', 3000);
		setTimeout(function(){
			var to_url = getQueryString('to_url');
			//$.toast(to_url, 3000);
			if (to_url == null) {
				window.location.href=data.data.url;
			}else{
				window.location.href=decodeURIComponent(to_url);
			}

		},3000)
  }

	function getQueryString(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]);
        return null; 
    } 

// 获取验证码
$('.sendCode').click(function(){
	if(!checkedP($(this).parents('.phoneBox'))){
		$.alert('请输入正确的手机号');
		return false;
	}
	var phone=$(this).parents('.phoneBox').find('.phoneNum').val();
	changeM_phone=phone;
	$(this).parents('.phoneBox').find('.phoneNum').attr('disabled','disabled').css('color','#333');
	$(this).parents('.phoneBox').find('.login_Btn').css('display','block');
	$(this).parents('.phoneBox').find('.inCode').css('display','block');
	$(this).css('display','none');
	dTime($(this).parents('.phoneBox').find('.dTime'));
	$.post('/newweixin/login_verification_code',{'mobile':changeM_phone},function(data){
		console.log(data)
	})
})



$('#login_code').find('.dTime').click(function(){
	$(this).html('<span>120s</span>后重新获取');
	dTime($(this));
	getCode_get(changeM_phone);
})

$('#rpasswordNext').find('.dTime').click(function(){
	$(this).html('<span>120s</span>后重新获取');
	dTime($(this));
	getCode_get(changeM_phone)
})

function getCode_get(){
	$.post('/newweixin/login_verification_code',{'mobile':changeM_phone},function(data){
		// console.log(data,'时间到点了再获取验证码');
	})
}

$('.login_next').click(function(event){
	$(this).attr('disabled',true);
	if(!checkedP($(this).parents('.phoneBox'))){
		$.alert('请输入正确的手机号');
		return false;
	}
	changeM_phone=$(this).prev().find('.phoneNum').val();
	if($(this).parents('.phoneBox').find('.getCode').length>0){
		if(!checkedC($(this).parents('.phoneBox'))){
			$.alert('请输入正确的6位验证码');
			return false;
		}
		var code=$(this).parent('.phoneBox').find('.getCode').val();
	}
	var _this=$(this),e=event;
	$.post('/newweixin/find_password',{'mobile':changeM_phone,'verification_code':code},function(data){
		if(data.errorno!=0){
			_this.removeAttr('disabled');
			$.alert(data.msg);
			return false;
		}else{
			$.router.load('#changePws');
			return false;
		}
	})
})

$('.resetPws').click(function(){
	$(this).attr('disabled',true);
	if(!checkedPassword($(this).parents('.phoneBox'),'.newPws')){
		$(this).removeAttr('disabled');
		$.alert('请输入正确的6-31位密码');
		return false;
	}
	var newC=$('.newPws').val();
	var align=$('.align_newPws').val();
	if(align==''){
		$(this).removeAttr('disabled');
		$.alert('请再次输入密码');
		return false;
	}
	if(!checkedPassword($(this).parents('.phoneBox'),'.align_newPws')){
		$(this).removeAttr('disabled');
		$.alert('请输入正确的6-31位密码');
		return false;
	}
	
	if(newC != align){
		$(this).removeAttr('disabled');
		$.alert('两次密码输入不一致');
		return false;
	}else{
		var _this=$(this);
		$.post('/newweixin/reset_password',{'mobile':changeM_phone,'pwd':align},function(data){

			if(data.data && typeof data.data.token  ==  'undefined'){
				$.alert('接口异常，请重试');
				_this.removeAttr('disabled');
				return false;
			}
			
			if(data.errorno!=0){
				_this.removeAttr('disabled');
				$.alert(data.msg);	
				return false;
			}else{
				do_login(data)
			}
		})
	}
})
