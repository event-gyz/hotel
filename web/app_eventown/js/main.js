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

// var 
var postData = {};
var cityitem = '';
var offsetObj = {};
var tag={}

// 1. Compile template function




$(document).on("pageInit", function(e, pageId, $page) {
    if (pageId == "mainPage") {
    } else if (pageId == "city-list") {
        cityitem = $('#cityContainer').find('li.cityitem');

        if (Object.keys(offsetObj).length > 0) {
            return
        }
        $('.list-group-title').each(function(k, v) {
            var a = $(v).text();
            offsetObj[a] = $(v).offset().top
        })
         // console.log(offsetObj)
    }
});


$('#activityNumber').on('focus',function(){
    $('#mainPage .footer').css({
        position:'static'
    })
})

$('#activityNumber').on('blur',function(){
    setTimeout(function(){
     $('#mainPage .footer').css({
        position:'absolute'
    })
    },300)
  
})

$(function() {
    //加载城市模板
    // $.post("/place/get_city_list?type=2",function(res){
    //    var tempFn = doT.template($('#cityTpl').html());
    //    var resultText = tempFn(res);
    //    $('#cityContainer').html(resultText);
    // })
    // var tempFn = doT.template($('#cityTpl').html());
    // var resultText = tempFn(cityData);
    // $('#cityContainer').html(resultText);
    //加载标签接口
    $.post(api+"/place/get_rfp_config",function(res){
        tag=res;
         $("#activityType").picker({
        toolbarTemplate: '<header class="bar bar-nav">\
        <button class="button button-link pull-right close-picker">确定</button>\
        <h1 class="title">活动类型</h1>\
        </header>',
        cols: [{
            textAlign: 'center',
            values: tag.option.room
        }]
    });
    if(GetRequest().from=='h5'){
        $('#toh5').show();
    }else{
        $('#toapp').show();
    }
    })


    /*
     * 第一步提交按钮 验证表单，跳转下一页
     */

    $('#nextStep').on('click', function() {
        var city = $('#ciyty-input').val(),
            date = $('#date-input').val(),
            activityNumber = $('#activityNumber').val(),
            activityType = $('#activityType').val();

            if(city==''){

                 $.toast('请选择举办城市');
                 return 

            }

            if(date==''){

                 $.toast('请选择活动日期');
                 return 

            }


            if(activityNumber==''){
                 $.toast(activityNumber+'请填写正确的活动人数');
                 return 
            }


            if(!/^[0-9]*$/.test($.trim(activityNumber))){

                 $.toast('活动人数格式不正确');
                 return 

            }

             if(activityType==''){

                 $.toast('请选择活动类型');
                 return 

            }
            $.router.load("#tagPage"); 

            generatorTagBySelected(city, activityType)

    })


    /*
     * 生成标签
     */

    function generatorTagBySelected(city, room) {
        var tagArr = [];
        var citytag = $.type(tag.tag.city_tag[city]) === 'undefined' ? tag.tag.city_tag['非热门城市'] : tag.tag.city_tag[city];
        var room_tag = $.type(tag.tag.room_tag[room]) === 'undefined' ? [] : tag.tag.room_tag[room];
        var other_tag = tag.tag.other_tag;
        var merge = function() {
            return Array.prototype.concat.apply([], arguments)
        }
        tagArr = merge(citytag, room_tag, other_tag);
        // 1. Compile template function
        var tempFn = doT.template($('#tagTpl').html());
        // 2. Use template function as many times as you like
        var resultText = tempFn(tagArr);
        $('.tagContainer').html(resultText)
    }


    /*
     * 城市选择
     */


    $('#cityContainer').on('touchend', 'li.cityitem .item-content', function() {

        // $(this).parents('.cityitem').siblings().css({
        //     color: ''
        // })

        // $(this).parents('.cityitem').css({
        //     color: '#f00'
        // })

        $('#ciyty-input').val($(this).parents('.cityitem').attr('title'));
        $('#ciyty-input').attr('city_id', $(this).parents('.cityitem').attr('id'));
        // $('.citylistback').trigger('touchend'),
        $.router.load("#mainPage");
        return false;
    })



    var chct=''; // 字母占位符
    var getChct=(function(){
         if(chct){
            return chct
        }else{
            chct=$('<span id="chct">').css({
                position:'absolute',
                left:'50%',
                top:'50%',
                fontSize:'1.2em',
                color:'#ccc',
                background:'#333',
                opacity:.6,
                zIndex:99999,
                width:'50px',
                textAlign:'center',
                margin:'-30px 0 0 -25px'
            }).appendTo($('body'))
        }
    })()


    $('#cityContainer').on('touchend', '.list-menu li', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var a = $(this).text();
        chct.show().html(a);

        setTimeout(function(){
            $('#chct').hide();
        },800)
        // location.href="#"+a
        $('#city-list .content').scrollTop(offsetObj[a]-50);
    })


    //标签选择
    $('.tagContainer').on('click', 'a', function() {
        $(this).toggleClass('active')
    })


    //城市搜索
    $('#city_search').on('input propertychange', function() {
        var key = $(this).val();
        if (key != '') {
            filterCity(key)
        } else {
            $('#cityContainer').find('li').show()
        }
    })



    function filterCity(name) {


        $('.list-group-title').hide();


        cityitem.each(function(k, v) {

            if ($(v).attr('title').search(name) >= 0 && $(v).attr('name') != 'hot') {
                $(v).show();
            } else {
                $(v).hide()
            }


        })
    }
   

    //提交
    $('#submitBtn').on('click', function() {

        var price = $('#price-input').val();
        var mobile = $('#mobile-input').val();

        // if (price == '') {
        //     $.alert('请填写预算价格');
        //     return

        // }

        if (!/^[0-9]*$/.test(price)) {

            $.toast('预算价格格式不正确');
            return

        }

        if (mobile == '') {
            $.toast('请填写联系方式');
            return

        }

        if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/i.test(mobile)) {
            $.toast('手机号码格式不正确');
            return
        }

        var tags =[];
        $('.tagContainer').find('.active').each(function() {
            tags.push($(this).text())
        })




        postData.city_id=$('#ciyty-input').attr('city_id');
        // postData.time= $('#date-input').val();
        postData.time_start=$('#date-input').val().split("至")[0];
        postData.time_end=$('#date-input').val().split("至")[1];
        postData.people_num=$('#activityNumber').val();
        postData.meeting_type=$('#activityType').val();
		postData.rfp_from=$('#rfp-from').val();
        postData.budget=price;
        postData.mobile=mobile;
        postData.tags=tags;  
        postData.note=$('#other-input').val()




        /***********/
         var success_html = '我在寻找在' + $('#ciyty-input').val() + '地区，' + postData.time_start+"至"+postData.time_end+ '，能够举办' + postData.meeting_type + '会议';
        if (postData.people_num != '不限') {
            success_html +=  '、且能容纳' + postData.people_num + '人的会议场地，';
        } else {
            success_html +=  '，';
        }
        if (tags.length != 0) {
            success_html += '如果是' + tags + '的场地就更好了。';
        }
        
        if (postData.budget != 0) {
            success_html += '预算' + postData.budget + '元。';
        }
        postData.meeting_type=$('#activityType').attr("data-id");
        postData.activity_name = success_html;
        //发送请求


         $.ajax({
                url:api+'/place/create_clue',
                type:'post',
                dataType: 'json',
                xhrFields:{withCredentials:true},
                data:postData,
                success: function(res){
                    if(res.errorno==0){
                        success_html = '<p>'+success_html+'</p>'; 
                        success_html += '<p>我的联系方式是' + postData.mobile + '，如有合适的场地麻烦与我联系，谢谢。</p>';
                        $('#success-text').html(success_html);
                        $.router.load("#successpage"); //加载内联页面
                    }else{
                        $.alert(res.msg);
                    }
                }
         })
    })
    //再次发布
    $(document).on('click','#successback',function(){
       $("input").val("");
       $("#ciyty-input").attr("city_id","0");
       $(".day.alive").removeClass("active").find(".tag").remove();
    })

});

