/**
 * Created by Zhang on 17/8/16.
 */
var VM = new Vue({
    el:'#app',
    data:{
        location:'',
        hotel_id:'',
        isAllDesc:0,
        descHeight: '80px',
        isAllServer: 0,
        isAllInfo: 0,
        infoList: [],
        msg:{}
    },
    computed: {

    },
    mounted: function(){
        var starch = decodeURI(window.location.search.substr(1));
        var params = starch.split('&');
        this.location = params[1].split('=')[1];
        this.hotel_id = params[0].split('=')[1];
        var _this = this;
        this.$nextTick(function () {
            $.ajax({
                url:api_url+'/hotel/get_hotel_details',
                type:'post',
                dataType: 'json',
                data:{
                    hotel_id:_this.hotel_id,
                    location:_this.location
                },
                success: function(responseData){
                    if(!responseData.errorno){
                        _this.msg = responseData.data;
                        _this.infoList.push(responseData.data.policy.PolicyInfoCodes[0]);
                    }else{
                        alert(responseData.msg);
                    }
                }
            });
            setTimeout(function(){
                var swiper = new Swiper('.swiper-container', {
                    autoplay: 5000,
                    pagination: '.swiper-pagination',
                    paginationType : 'custom',
                    paginationCustomRender: function (swiper, current, total) {
                        $('.swiper-count').text(current +'/'+total);
                    }
                });
            },1000)
        });
    },
    methods: {
        showDesc: function(n){
            this.descHeight = n;
            if(n == 'auto'){
                this.isAllDesc = 1;
            }else{
                this.isAllDesc = 0;
            }
        },
        showInfo: function(type){
            if(type == 1){
                this.isAllInfo = 1;
                this.infoList = this.msg.policy.PolicyInfoCodes.slice(0);
            }else{
                this.isAllInfo = 0;
                this.infoList = [this.msg.policy.PolicyInfoCodes[0]];
            }
        }


    }
});