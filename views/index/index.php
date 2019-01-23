<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>首页</title>
    <script src="/js/jquery-1.8.2.js"></script>
</head>
<body>
<style>
    /*body {*/
        /*background-image: url(/images/index_bg.jpeg);*/
        /*background-repeat: no-repeat;*/
        /*background-position: center;*/
        /*background-size: cover;*/
        /*height: 100vh;*/
        /*margin: 0px;*/
        /*padding: 0px;*/
    /*}*/
    body {
        background: url("/images/index_bg.jpeg");
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-attachment: fixed;
        margin: 0px;
        padding: 0px;
    }

</style>
<div  class="index">

</div>

</body>
<script>
    $('.index').width($(window).width());
    $('.index').height($(window).height());
    $('.index').click(function () {
        window.location.href = "/index/list";
    })
</script>
</html>