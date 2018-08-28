/**
 * Created by Zhang on 17/8/16.
 */
function formatWeek(n){
    switch(n)
    {
        case 1:
            return '周一';
            break;
        case 2:
            return '周二';
            break;
        case 3:
            return '周三';
            break;
        case 4:
            return '周四';
            break;
        case 5:
            return '周五';
            break;
        case 6:
            return '周六';
            break;
        case 0:
            return '周日';
            break;
    }
}
function get_gap_day(start,end){
    return (new Date(end).getTime()-new Date(start).getTime())/(60000*60*24);
}
var VM = new Vue({
    el:'#app',
    data:{
        hotel_location:'',
        platform:'',
        start_input:'',
        end_input:'',
        start_cn:'',
        end_cn:'',
        start_week:'',
        end_week:'',
        gap_day:'',
        isMask:0,
        pop_img:0,
        room_info:0,
        start_date: '',
        end_date: '',
        location:'',
        cur_location:'',
        city_location:'',
        hotel_id:'',
        ctrip_id:'',
        mapHotel: [],
        hotelInfo: [],
        roomList: [],
        img_pop_obj:{},
        info_pop_obj:{}
    },
    computed: {

    },
    mounted: function(){
        var _this = this;
        this.$nextTick(function () {
            var starch = decodeURI(window.location.search.substr(1));
            var params = starch.split('&');
            var paramsObj = {};
            params.forEach(function(item,index){
                var k = item.split('=')[0];
                var v = item.split('=')[1];
                paramsObj[k] = v;
            });
            this.platform = paramsObj.platform;
            this.start_date = paramsObj.start_date;
            this.end_date = paramsObj.end_date;
            this.gap_day = get_gap_day(this.start_date,this.end_date);
            this.start_cn = this.start_date.slice(5).replace('-','月')+'日';
            this.end_cn = this.end_date.slice(5).replace('-','月')+'日';
            this.start_week= formatWeek(moment(this.start_date).day());
            this.end_week= formatWeek(moment(this.end_date).day());
            this.cur_location = paramsObj.cur_location;
            this.city_location = paramsObj.city_location;
            this.hotel_id = paramsObj.h_id;
            this.ctrip_id = paramsObj.c_id;
            //获取当前位置
            _this.mapHotelFn();
            _this.getRoomList();
            _this.getHotelInfo();


            setTimeout(function(){
                swiper = new Swiper('.swiper-container', {
                    autoplay: 5000,
                    pagination: '.swiper-pagination',
                    paginationType : 'custom',
                    paginationCustomRender: function (swiper, current, total) {
                        $('.swiper-count').text(current +'/'+total);
                    }
                });
                swiper1 = new Swiper('.swiper-container1', {
                    autoplay: 5000,
                    pagination: '.swiper-pagination1',
                    paginationType : 'custom',
                    observer:true,
                    observeParents:true,
                    paginationCustomRender: function (swiper, current, total) {
                        $('.swiper-count1').text(current +'/'+total);
                    }
                });
                $("#date-start").calendar({
                    value: [_this.start_date],
                    minDate: moment().subtract(1, 'day').format('YYYY-MM-DD'),
                    maxDate: moment().add(29, 'day').format('YYYY-MM-DD'),
                    dateFormat: 'yyyy-mm-dd',
                    onChange:function(p, values, displayValues){
                        if(this.value[0] == values[0]){return;}
                        var flag = 1;
                        if(_this.start_date == values[0]){
                            flag = 0;
                        }
                        this.value[0] = values[0];
                        _this.start_date = values[0];
                        _this.start_cn = values[0].slice(5).replace('-','月')+'日';
                        _this.end_date = moment(values[0]).add(1,'day').format('YYYY-MM-DD');
                        _this.end_cn = _this.end_date.slice(5).replace('-','月')+'日';
                        _this.start_week = formatWeek(moment(values[0]).day());
                        _this.end_week = formatWeek(moment(_this.end_date).day());
                        _this.gap_day = get_gap_day(_this.start_date,_this.end_date);
                        $("#date-end").calendar("destroy");//销毁结束日历对象
                        $("#date-end").calendar({
                            value: [_this.end_date],
                            minDate: _this.end_date,
                            maxDate: moment().add(30, 'day').format('YYYY-MM-DD'),
                            dateFormat: 'yyyy-mm-dd',
                            onChange:function(p, values, displayValues){
                                var flag_t = 1;
                                if(_this.end_date == values[0]){
                                    flag_t = 0;
                                }
                                _this.end_date = values[0];
                                _this.end_cn = values[0].slice(5).replace('-','月')+'日';
                                _this.end_week = formatWeek(moment(values[0]).day());
                                _this.gap_day = get_gap_day(_this.start_date,_this.end_date);
                                if(flag_t){
                                    _this.getRoomList();
                                }
                            }
                        });
                        if(flag){
                            _this.getRoomList();
                        }
                    }
                });
                $("#date-end").calendar({
                    value: [_this.end_date],
                    minDate: _this.start_date,
                    maxDate: moment().add(30, 'day').format('YYYY-MM-DD'),
                    dateFormat: 'yyyy-mm-dd',
                    onChange:function(p, values, displayValues){
                        var flag_t = 1;
                        if(_this.end_date == values[0]){
                            flag_t = 0;
                        }
                        _this.end_date = values[0];
                        _this.end_cn = values[0].slice(5).replace('-','月')+'日';
                        _this.end_week = formatWeek(moment(values[0]).day());
                        _this.gap_day = get_gap_day(_this.start_date,_this.end_date);
                        if(flag_t){
                            _this.getRoomList();
                        }
                    }
                });
            },1500);
        });
    },
    methods: {
        goBack: function(){
            if(this.city_location){
                window.location.href='/hotel/lists?cityId='+this.hotelInfo.city_id+'&startTime='+this.start_date+'&endTime='+this.end_date+'&city_location='+this.city_location+'&cityName='+this.hotelInfo.city_name;
            }else{
                window.location.href='/hotel/lists?cityId='+this.hotelInfo.city_id+'&startTime='+this.start_date+'&endTime='+this.end_date+'&cur_location='+this.cur_location+'&cityName='+this.hotelInfo.city_name;
            }
        },
        //隐藏房间信息
        hide_room_info: function(){
            this.isMask = 0;
            this.room_info = 0;
        },
        //显示房间信息弹层
        show_room_info: function(outerObj,obj){
            obj.NotAllowSmoking = outerObj.NotAllowSmoking;
            this.info_pop_obj =obj;
            this.info_pop_obj.outRoomName = outerObj.RoomName;
            this.info_pop_obj.policyText = obj.policyText.replace('PRICE',this.gap_day*obj.AveragePrice);
            this.isMask = 1;
            this.room_info = 1;
        },
        //显示房间图片弹层
        show_pop_img: function(obj){
            this.isMask = 1;
            this.pop_img = 1;
            this.img_pop_obj = {
                name: obj.RoomName,
                pics: obj.pics,
                NotAllowSmoking: obj.NotAllowSmoking,
                AreaRange: obj.RoomInfo[0].AreaRange,
                FloorRange: obj.RoomInfo[0].FloorRange.split('-')[0],
                Person: obj.RoomInfo[0].Person,
                bedInfo: obj.RoomInfo[0].bedInfo
            };
        },
        //关闭房间图片弹层
        hide_pop_img: function(){
            this.isMask = 0;
            this.pop_img = 0;
        },
        //显示全部房间
        showRooms: function(obj,n){
            if(n == 'all'){
                obj.littleRooms = obj.RoomInfo.slice(0);
            }else{
                obj.littleRooms = obj.RoomInfo.slice(0,n);
            }

        },
        //周边酒店
        mapHotelFn: function(){
            var _this = this;
            $.ajax({
                url:api_url+'/hotel/get_similar_hotels',
                type:'post',
                dataType: 'json',
                data:{
                    location:_this.getLocation()
                },
                success: function(responseData){
                    if(!responseData.errorno){
                        _this.mapHotel = responseData.data.rows;
                    }else{
                        alert(responseData.msg);
                    }
                }
            });
        },
        getLocation:function(){
            if(this.city_location && this.city_location!='undefined'){
                return this.city_location;
            }else{
                return this.cur_location;
            }
        },
        //酒店信息
        getHotelInfo: function(){
            var _this = this;
            var data = {hotel_id:_this.hotel_id};
            if(this.city_location!='undefined' && this.city_location!=''){
                data.city_location = this.city_location;
            }else{
                data.location = this.cur_location;
            }
            $.ajax({
                url:api_url+'/hotel/get_hotel_details',
                type:'post',
                dataType: 'json',
                data:data,
                success: function(responseData){
                    if(!responseData.errorno){
                        _this.hotelInfo = responseData.data
                        function smap(hotel_location){
                            var map = new BMap.Map("allmap");
                            var point = new BMap.Point(hotel_location.split(',')[1],hotel_location.split(',')[0]);
                            map.centerAndZoom(point, 12);
                            var marker = new BMap.Marker(point);// 创建标注
                            map.addOverlay(marker);             // 将标注添加到地图中
                            marker.disableDragging();
                        }
                        smap(responseData.data.location);
                        _this.hotel_location = responseData.data.location;
                    }else{
                        alert(responseData.msg);
                    }
                }
            });
        },
        //房间列表
        getRoomList: function(){
            var _this = this;
            $.ajax({
                url:api_url+'/hotel/get_room_data',
                type:'post',
                dataType: 'json',
                data:{
                    startTime:_this.start_date,
                    endTime:_this.end_date,
                    hotel_id:_this.hotel_id,
                    ctrip_id:_this.ctrip_id
                },
                success: function(responseData){
                    if(!responseData.errorno){
                        var data = responseData.data;
                        data.forEach(function(item,index){
                            item.isShown = 0;
                            item.littleRooms = item.RoomInfo.slice(0,3);
                        });
                        _this.roomList = responseData.data;
                        $('#main-box').show();
                        $('#global_login').hide();
                    }else{
                        alert(responseData.msg);
                    }
                }
            });
        }

    }
});
