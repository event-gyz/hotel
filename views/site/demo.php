<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>大企业登陆页面</title>
	<style>
	*{
		margin: 0;
		padding: 0
	}
	</style>
</head>
<body bgcolor="#FFFFFF" >
<!-- Save for Web Slices (大企业登陆页面.psd) -->
<table id="__01" width="100%"  border="0" cellpadding="0" cellspacing="0" style="margin:0 auto; max-width:1920px">
	<tr>
		<td>
			<img src="/img/b_01.jpg" width="100%"  alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_02.jpg" width="100%" alt=""></td>
	</tr>
	<tr>
		<td>
			<img id="loginBtn" src="/img/b_03.jpg" width="100%" alt="" style="cursor:pointer"></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_04.jpg" width="100%"  alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_05.jpg" width="100%"  alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_06.jpg" width="100%" alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_07.jpg" width="100%"  alt=""></td>
	</tr>
	<tr>
		<td>
			<img src="/img/b_08.jpg" width="100%" alt=""></td>
	</tr>
</table>

<script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>

<script src="/plugins/layer/layer.js"></script>
<script>

//初体验
	
	$('#loginBtn').click(function() {


			layer.open({
			  type: 2,
			    title: '登录',
			  area: ['480px', '650px'],
			  skin: 'layui-layer-rim', //加上边框
			  content: ['/site/loginbak', 'no']
			});



		// body...
	})

</script>
<!-- End Save for Web Slices -->
</body>
</html>