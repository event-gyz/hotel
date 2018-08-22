


var postData = {};
var cityitem = '';
var offsetObj = {};


                // 1. Compile template function




$(document).on("pageInit", function(e, pageId, $page) {
    if (pageId == "mainPage") {




    } else if (pageId == "city-list") {

        cityitem = $('#cityContainer').find('li.cityitem');

        if (Object.keys(offsetObj).length > 0) {
            return
        }
        // $('#city-list .content').scrollTop(0);
        $('.list-group-title').each(function(k, v) {
            var a = $(v).text();
            offsetObj[a] = $(v).offset().top

        })

        console.log(offsetObj)


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

        var tempFn = doT.template($('#cityTpl').html());
        // 2. Use template function as many times as you like
        var resultText = tempFn(cityData);

        $('#cityContainer').html(resultText);







    /*
     * 第一步提交按钮 验证表单，跳转下一页
     */

    $('#nextStep').on('click', function() {

        var city = $('#ciyty-input').val(),
            date = $('#date-input').val(),
            activityNumber = $('#activityNumber').val(),
            activityType = $('#activityType').val();

            if(city==''){

                 $.alert('请选择举办城市');
                 return 

            }

            if(date==''){

                 $.alert('请选择活动日期');
                 return 

            }


            if(activityNumber==''){
                 $.alert(activityNumber+'请填写正确的活动人数');
                 return 
            }


            if(!/^[0-9]*$/.test($.trim(activityNumber))){

                 $.alert('活动人数格式不正确');
                 return 

            }

             if(activityType==''){

                 $.alert('请选择活动类型');
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
        var citytag = $.type(cityData.tag.city_tag[city]) === 'undefined' ? cityData.tag.city_tag['非热门城市'] : cityData.tag.city_tag[city];

        var room_tag = $.type(cityData.tag.room_tag[room]) === 'undefined' ? [] : cityData.tag.room_tag[room];

        var other_tag = cityData.tag.other_tag;


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




    $("#activityType").picker({
        toolbarTemplate: '<header class="bar bar-nav">\
        <button class="button button-link pull-right close-picker">确定</button>\
        <h1 class="title">活动类型</h1>\
        </header>',
        cols: [{
            textAlign: 'center',
            values: cityData.option.room
        }]
    });



    /*
     * 城市选择
     */


    $('#cityContainer').on('touchend', 'li.cityitem .item-title', function() {

        $(this).parents('.cityitem').siblings().css({
            color: ''
        })

        $(this).parents('.cityitem').css({
            color: '#f00'
        })

        $('#ciyty-input').val($(this).parents('.cityitem').attr('title'));
        $('#ciyty-input').attr('city_id', $(this).parents('.cityitem').attr('id'));

        $.router.back()

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


    //    console.info(cityitem);

    function filterCity(name) {


        $('.list-group-title').hide();


        cityitem.each(function(k, v) {

            if ($(v).attr('title').search(name) >= 0 && $(v).attr('name') != '热门') {
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

            $.alert('预算价格格式不正确');
            return

        }

        if (mobile == '') {
            $.alert('请填写联系方式');
            return

        }

        if (!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/i.test(mobile)) {
            $.alert('手机号码格式不正确');
            return
        }

        var tags = [];
        $('.tagContainer').find('.active').each(function() {
            tags.push($(this).text())
        })




        postData.city_id=$('#ciyty-input').attr('city_id');
        postData.time= $('#date-input').val();
        postData.people_num=$('#activityNumber').val();
        postData.meeting_type=$('#activityType').val();
		postData.rfp_from=$('#rfp-from').val();
        postData.budget=price;
        postData.mobile=mobile;
        postData.tags=tags;
        
        postData.clue_note=$('#other-input').val()




        /***********/
         var success_html = '<p>我在寻找在' + $('#ciyty-input').val() + '地区，' + postData.time.replace(/(\d*)\/(\d*)\/(\d*)至(\d*)\/(\d*)\/(\d*)/, "$1年$2月$3日至$4年$5月$6日") + '，能够举办' + postData.meeting_type + '会议';
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
        success_html += '</p>';
        
        postData.activity_name = success_html;

        var share_title = '我在寻找' + postData.time.replace(/(\d*)\/(\d*)\/(\d*)至(\d*)\/(\d*)\/(\d*)/, "$2.$3-$5.$6") + '能够容纳' + postData.people_num + '人的会议场地，谁能接？—会唐网'
        
        wx.onMenuShareTimeline({
            title: share_title,
            link: encodeURI('http://m.eventown.com/newweixin/rfp_share/?content=' + success_html + '&share_title=' + share_title), // 分享链接
            imgUrl: 'http://m.eventown.com/public/logo.png', // 分享图标
        });
        
        wx.onMenuShareAppMessage({
            title: share_title, // 分享标题
            desc: '找场地，上会唐！', // 分享描述
            link: encodeURI('http://m.eventown.com/newweixin/rfp_share/?content=' + success_html + '&share_title=' + share_title), // 分享链接
            imgUrl: 'http://m.eventown.com/public/logo.png', // 分享图标
        });

        
        success_html += '<p>我的联系方式是' + postData.mobile + '，如有合适的场地麻烦与我联系，谢谢。</p>';
        $('#success-text').html(success_html);
        $.router.load("#successpage"); //加载内联页面

        $.post('/newweixin/create_rfp', postData, function(res) {
        })



        /***********/



    })

});
// 分享

$(document).on('click', '#share-btn', function() {
    $.alert('请点击微信右上角菜单分享');
});
