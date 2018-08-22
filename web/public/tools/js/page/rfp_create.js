     //验证

   var validatorform = $('#rfp_create').validate()

 /*类型选择*/
 $('#placeTypeFilter').on('click','li',function(){

    $(this).siblings().removeClass('active').end().addClass('active');
    var text=$(this).find('a').text();
    $('#place_type').show().find('span').text($(this).find('a').text()).end().find('input').val($(this).attr('value'));

 })

  /*位置选择*/
 $('#placeLocationFilter').on('click.set','li.text-ellipsis',function(){

    $(this).siblings().removeClass('active').end().addClass('active');

    var text=$(this).find('a').text();

    $('#positionInput').val($(this).attr('data-val'))
    $('#place_location').show().find('span').text($(this).find('a').text()).end().find('input').val($(this).attr('value'))


 })

  /*星级选择*/
 $('#placeStarFilter').on('click','li',function(){

    $(this).siblings().removeClass('active').end().addClass('active');

    var text=$(this).find('a').text();
    $('#starInput').val($(this).attr('data-val'))
    $('#place_start').show().find('span').text($(this).find('a').text()).end().find('input').val($(this).attr('value'))


 })

 //清除条件
 $('#clearFliter').click(function(){

    $('.no-select').trigger('click')

 })

//初始化日期

var getOffDays = function(startDate, endDate) {  

             //得到时间戳相减 得到以毫秒为单位的差  

             var mmSec = (endDate.getTime() - startDate.getTime());

             //单位转换为天并返回 

             return (mmSec / 3600000 / 24); 

            };  


function setDatePicker(){
    var datapicker=    $('input.datapicker').datepicker({
        language: "zh-CN",
    autoclose: true,
    todayHighlight: false,
    startDate:new Date()
    })
    .on('hide', function(e) {
        var el=$(e.target);

        // if(el.hasClass('the_end'))

        var parent=el.closest('.room_item')
            var s=parent.find('.the_start').val();
            var e=parent.find('.the_end').val();

                if(s!='' && e !=''){

           var off= getOffDays(new Date(s), new Date(e));

           parent.find('.long').val(off)

                           }

    })
}

 setDatePicker()



//会议室需求



//餐饮需求
var i=1000;
$('#food-needs').find('.meat_item.tpl').find('.rm_btn').css({'visibility':'hidden'})

$('#food-needs').on('click','.wineBtn',function(){
    if($(this).attr('need')=='no'){
        $(this).attr('need','yes');
        if($('#wineList').css('display')=='block'){
            addWine()
        }else{
           $('#wineList').css('display','block'); 
        }
    }else{
        $(this).attr('need','no');
        var len=$('#wineList').find('.meat_item').length;
        if(len!=1){
            removeWine()
        }else{
           $('#wineList').css('display','none'); 
        }
    }
})
// 添加
$("#food-needs").on('click','.wadd_btn',function(){
    addWine($(this));
})

function addWine(obj){
    i++ 
    var tpl=$('#food-needs').find('.meat_item.wine').html();
    var newhtml= tpl.replace(/1000/g,i).replace(/hidden/g,'visible').replace(/input(.*)type="text"(.*)value="\S+"/g,'input $2 value=""').replace(/yes/g,'false');
    $('<div class="row por meat_item">').html(newhtml).appendTo($('#wine_container'));   
    setDatePicker()
}
function removeWine(){
    $('#food-needs').find('.meat_item')[$('#food-needs').find('.meat_item').length-1].remove();
}


$('#food-needs').on('click','.add_btn',function(){
    if($('#food-needs').find('.meat_item').size()>100){return}
    i++;
    var tpl=$('#food-needs').find('.meat_item.tpl').html();
    var newhtml= tpl.replace(/1000/g,i).replace(/yes/g,'no').replace(/hidden/g,'visible').replace(/input(.*)type="text"(.*)value="\S+"/g,'input $2 value=""');
    $('<div class="row por meat_item">').html(newhtml).appendTo($('#food_container'));
    setDatePicker()
})


$('#food-needs').on('click','.rm_btn',function(){
   $(this).closest('.meat_item').remove()
})


//房间需求
// $('#food-needs').find('.meat_item').clone()

$('#room-needs').find('.room_item.tpl').find('.rm_btn').css({'visibility':'hidden'})


$('#room-needs').on('click','.add_btn',function(){
    if($('#room-needs').find('.room_item').size()>=5 ){
        return 
    }
    i++;
     var tpl =  $('#room-needs').find('.room_item.tpl').html();
     var newhtml= tpl.replace(/1000/g,i).replace(/hidden/g,'visible').replace(/input(.*)type="text"(.*)value="\S+"/g,'input $2 value=""');
        $('<div class="row por room_item">').html(newhtml)
    .appendTo($('#room_container'));
     setDatePicker();
})

$('#room-needs').on('click','.rm_btn',function(){
   $(this).closest('.room_item').remove()
})


// 酒水外彩

$('#wineTList').on('click','.add_btn',function(){
    i++;
    var tpl =  $('#wineT_container').find('.room_item.wineT').html();
     var newhtml= tpl.replace(/1000/g,i).replace(/hidden/g,'visible').replace(/input(.*)type="text"(.*)value="\S+"/g,'input $2 value=""');
        $('<div class="row por room_item">').html(newhtml)
    .appendTo($('#wineT_container'));
})
$('#wineTList').on('click','.rm_btn',function(){
  $(this).parents('.room_item').remove();
})


// 指定场地参与报价

$('#addPlace').click(function(){
    layer.open({
      type: 1,
      title: '场地搜索',
      shade: 0.5,
      area: ['600px', '510px'],
      btn:['添加','取消'],
      yes:function(){
    	  $('.layui-layer').find('.radioCheck').each(function(){
    		  console.log($(this).prop('checked'));
    		  if($(this).prop('checked')){
    	  		  var place_data=$(this).attr('place_data');
    	  		  var place_name=$(this).attr('place_name');
    	  		  $('input[name="selectPlaceList"]').val(place_data);
    	  		  $('#placeName').html(place_name)
    	  		  return false;
    		  }
    	  })
    	  layer.closeAll();
      },
      // no:function(){alert('no')},
      content:$('#place').html()
    }); 
})

$('#clearData').click(function(){
	$('input[name="selectPlaceList"]').val('');
	$('#placeName').html('请选择场地');
})

function loadPlaceList(pageNo,val){
	$('.search_place').append('<div class="seachList">加载中</div>');
	
	$.get(searchPlaceUrl+val+'&pageNo='+pageNo,function(data){
		$('.seachList').remove();
		$('.pageBtn').remove();
		$('.search_place').append(data);
	})
}



//搜索框数据
var place_page=1;
var num=0;
var limit=10;
var pageNum=0;
var val='';
function ajaxGet(val){
	$.get(searchPlaceUrl,{'keyword':val,'pageNo':place_page,'limit':limit},function(data){
		var data=eval('('+data+')');
		num=data.totalRows;
		var list=data.data; 
		var html='';
		pageNum=Math.ceil(num/limit);
		for(var n in list){
			html+='<tr><td><input name="row" class="radioCheck" place_name='+list[n].place_name+' type="radio" place_data='+list[n].place_id+'|'+list[n].place_name+' /></td><td>'+list[n].place_name+'</td><td>'+list[n].province_name+'</td><td>'+list[n].city_name+'</td></tr>'
		}
		
		$('.layui-layer').find('.placeList').html(html);
	})
}
$(document).on('click','.seachBtn',function(){
	val=$(this).parent().prev().find('.seachBox').val();
	ajaxGet(val);
})
//	上一页
$(document).on('click','.seachPageUp',function(){
	if(place_page<2){
		layer.msg('第一页');
		return ;
	}else{
		place_page--;
		ajaxGet(val)
	}
})
$(document).on('click','.seachPageDown',function(){
	if(place_page==pageNum){
		layer.msg('最后一页在了');
		return ;
	}else{
		place_page++;
		ajaxGet(val);
	}
})



//联系人
// $('#food-needs').find('.meat_item').clone()

$('#contacts').on('click','.add_btn',function(){
     if($('#contacts').find('.contact-item').size()>=5 ){
        return 
    }
     var tpl =   $(this).parents('.contact-item').clone();
         tpl.find('input').attr('value','');
       // var html= createTpl(tpl);
       tpl.appendTo($('#contacts_container'));
})

$('#contacts').on('click','.rm_btn',function(){
         if($('#contacts').find('.contact-item').size()<=1 ){
        return 
    }
   $(this).closest('.contact-item').remove()
})






 $(".spinner").TouchSpin({
        buttondown_class: 'btn btn-white spinner-btn-sm',
        buttonup_class: 'btn btn-white spinner-btn-sm'
    });
    $('.onoffswitch-checkbox').each(function() {
        $(this).on('click', function() {
            $(this).parents('.toggl-title').next().slideToggle(300)
            var val = $(this).val()
            if(val==1){
            	$(this).val(0)
            }else{
            	$(this).val(1)
            }
        })
    });
    // 摆台形式tips
    $('.tip').each(function() {
        var $con = $(this).siblings('div.pro_tips_layer').html();
        $(this).tipso({
            useTitle: false,
            width: 320,
            content: $con
        });
    })


//**date time picker**/

$('.datatimepicker').datetimepicker({
        weekStart: 1,
        todayBtn:  0,
        autoclose: 1,
        forceParse: 0,
        language:'zh-CN'
    });


/*计算价格*/


$(document).on('keydown','.food_one,.j_total',function(event){


if (!((event.keyCode==110) || (event.keyCode==190) || (event.keyCode>=48&&event.keyCode<=57)||(event.keyCode=='undefined' )||(event.keyCode==8)|| (event.keyCode>=96&&event.keyCode<=105)))
  { 
  
  event.returnValue=false;
  
  event.preventDefault()
  
  }

})

$(document).on('keyup','.food_one',function(event){


var num=  $(this).parents('.meat_item').find('.j_num').val();
  
var price=  $(this).parents('.meat_item').find('.j_price').val();
  
$(this).parents('.meat_item').find('#foodAllPrice').val(num*price)

set_food_price_all()
})


$(document).on('keyup','.j_total',function(event){
  set_food_price_all()
})


$(document).on('keyup','.w_num',function(){
  var Nparent=$(this).parents('.meat_item');
  var num=Number($(this).val());
  var price=Number(Nparent.find('.w_price').val());
  if(isNaN(price) || price==''){
    price=0;
  }
  var all=num*(price*100);
  $(this).parents('.meat_item').find('.j_total').val(all/100);
  set_food_price_all();
})

$(document).on('keyup','.w_price',function(){
  var Pparent=$(this).parents('.meat_item');
  var price=Number($(this).val());
  var num=Number(Pparent.find('.w_num').val());
  console.log(num);
  if(isNaN(num) || num==''){
    num=0;
  }
  var all=num*(price*100);
  $(this).parents('.meat_item').find('.j_total').val(all/100);
  set_food_price_all();
})



/*自动计算餐饮总价*/
function set_food_price_all(){
   var price=0;
    $('.j_total').each(function(index,el){
      //console.log($(el).val());
      price +=$(el).val()*100;
    })

   price = price/100;
    $('#food_price_all').val(price);
   $('#food_price_all').trigger('change')
   return price
}

/*自动计算预算*/
$(document).on('keyup change','.total_price_item',function(event){

      set_yusuan_price()
})





function set_yusuan_price(){

    var price=0;

    $('.total_price_item').each(function(){
        var c=$.trim($(this).val());
        if(isNaN(c) || c=='') {c= 0} ;
       //price+= parseInt(c)
        price+= c*100;
    })

    price = price/100;
    $('#yusuan').val(price);

    var p=$('input[name="applyBudget"]').val();

    if( price > p ){

        alert('实际预算已经大于审批预算')
    }

}
