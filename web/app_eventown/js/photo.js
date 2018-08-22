/**
 * Created by Zhang on 17/6/16.
 */
var id =  location.search.split('=')[1];
var VM=new Vue({
    el:'#app',
    data: {
        isMask: 'block',
        msg:{}
    },
    mounted: function() {
       var that = this;
       $.get(api+'/place/get_photo',{place_id:id}, function(data){
        console.log(data.data)
             that.msg=data.data;
       })
    },
    updated: function(){
        this.isMask = 'none';
        imgMAX();
    }
});
var x= 0;
function imgMAX(){
    x++;
    if(x>1){return}
    $('.hotel-photo-title a').each(function (i) {
        var i =  i+1;
        var imgUrl= [];
        var _name = '.photo0'+ i + '>' +'.hotel-photo'
        $(_name).each(function(i) {
            imgUrl.push($(this).find('img').attr("data-url"));
            $(this).find('img').click(function() {
                var hotelPhoto = $.photoBrowser({
                    items: imgUrl,
                    initIndex: i
                });
                hotelPhoto.open();
            });
        })
    });
}

