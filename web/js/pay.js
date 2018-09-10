/**
 * Created by Zhang on 17/8/16.
 */

var VM = new Vue({
    el:'#app',
    data:{
        screenHeight:0,
        start_cn:0,
        end_cn:0,
        is_submit_ing:0,
        tip_text:'',
        AvailableQuantity:0,
        priceList:[],
        text: '提交中...',
        msg:{
            dayArr:[],
            is_info: 0,
            hotel_name:'',
            room_number:1,
            isShowRoom:0,
            contacter_name:'',
            contacter_phone:'',
            order_requirement:'',
            is_invoice:0,
            person:[' '],
            invoice_type:1,
            taxpayer_number:'',
            invoice_title:'',
            consignee:'',
            phone:'',
            address:'',
            address_info:'',
            once_price:0,
            price:0,
            roomAllPrice:0,
            gap_day:1,
            allPrice:0
        }
    },
    computed: {},
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
            this.msg.hotel_id = paramsObj.hotel_id;
            this.msg.hotel_name = paramsObj.hotel_name;
            this.msg.city_id = paramsObj.city_id;
            this.msg.city_name = paramsObj.city_name;
            this.msg.room_id = paramsObj.room_id;
            this.msg.room_name = paramsObj.room_name;
            this.msg.roomName = paramsObj.roomName;
            this.msg.ctrip_id = paramsObj.ctrip_id;
            this.msg.ArrivalDate = paramsObj.ArrivalDate;
            this.msg.DepartureDate = paramsObj.DepartureDate;
            this.start_cn = this.msg.ArrivalDate.slice(5).replace('-','月')+'日';
            this.end_cn = this.msg.DepartureDate.slice(5).replace('-','月')+'日';
            this.msg.gap_day = paramsObj.gap_day;
            this.msg.hotel_address = paramsObj.hotel_address;
            this.msg.breakfast = paramsObj.breakfast;
            this.msg.bedInfo = paramsObj.bedInfo;
            this.msg.once_price = paramsObj.price;
            this.msg.price = paramsObj.price*paramsObj.gap_day;
            this.msg.allPrice = paramsObj.price*paramsObj.gap_day;
            this.msg.roomAllPrice = paramsObj.price*paramsObj.gap_day;
            this.msg.RatePlanCategory = paramsObj.RatePlanCategory;
            this.msg.pay_type = paramsObj.pay_type;
            this.msg.policyType = paramsObj.policyType;
            this.cur_location=paramsObj.cur_location;
            this.msg.dayArr = getDay(paramsObj.ArrivalDate,paramsObj.gap_day);
            //设置每晚数组
            function getDay(cur,len){
                var arr = [];
                for(var i=0;i<len;i++){
                    arr.push(moment(cur).add(i,'day').format('YYYY-MM-DD'));
                }
                return arr;
            }
            //地址
            $("#city-picker").cityPicker({
                title: "地址选择",
                onChange: function(a,b,c){
                    _this.msg.address = c.join(' ');
                }
            });
            $("#city-picker").on('click',function(){
                $('input').blur();
            });
            this.getRoomMsg();
            this.screenHeight = ($(window).height()-50);
            $(window).resize(function() {
                _this.screenHeight = ($(window).height()-50);
            });
        });
    },
    methods: {

        getRoomMsg: function(){
            var _this = this;
            $.ajax({
                url:api_url+'/order/check_room_number',
                type:'post',
                dataType: 'json',
                data:{
                    room_id: _this.msg.room_id,
                    ctrip_id: _this.msg.ctrip_id,
                    ArrivalDate: _this.msg.ArrivalDate,
                    DepartureDate: _this.msg.DepartureDate,
                    room_number:1,
                    person:'a',
                    RatePlanCategory: _this.msg.RatePlanCategory
                },
                success: function(responseData){
                    $('#main-box').show();
                    $('#global-max').hide();
                    $('#global_login').hide();
                    if(!responseData.errorno){
                        var arr = responseData.data.priceList;
                        _this.msg.price = 0;
                        _this.msg.allPrice = 0;
                        _this.msg.roomAllPrice = 0;
                        for(var i=0;i<arr.length;i++){
                            _this.msg.price+= Number(arr[i].price);
                            _this.msg.allPrice+= Number(arr[i].price);
                            _this.msg.roomAllPrice+= Number(arr[i].price);
                        }
                        _this.tip_text = responseData.data.policyText;
                        _this.msg.LastCancelTime = responseData.data.LastCancelTime;
                        _this.AvailableQuantity = responseData.data.AvailableQuantity;
                        _this.priceList = responseData.data.priceList;
                    }else{
                        _this.is_submit_ing = 1;
                        _this.text='不可预订';
                        util.m.alert(responseData.msg);
                    }
                }
            })
        },
        //返回上一页
        goBack: function(){
            util.m.confirm('订单尚未提交，确认放弃填写',function(){},function(){
                history.go(-1);
            })
        },
        close: function(){
            this.msg.is_info = 0;
            $('#global-max').hide();
        },
        showRoom: function(n){
            if(n){
                this.msg.isShowRoom = 1;
            }else{
                this.msg.isShowRoom = 0;
            }
        },
        setRoomLength: function(n){
            if(this.AvailableQuantity<n){
                return;
            }
            if(n>this.msg.room_number){
                var m = n-this.msg.person.length;
                for(var i=0;i<m;i++){
                    this.msg.person.push(' ');
                }
            }else{
                this.msg.person= this.msg.person.slice(0,n);
            }
            this.msg.isShowRoom = 0;
            this.msg.room_number = n;
            this.msg.roomAllPrice = n*this.msg.price;
            if(this.msg.is_invoice){
                this.msg.allPrice = n*this.msg.price+10;
            }else{
                this.msg.allPrice = n*this.msg.price;
            }
        },
        setOrder_requirement:function(str){
            this.msg.order_requirement = str;
        },
        select_is_invoice: function(){
            if(this.msg.is_invoice){
                this.msg.is_invoice = 0;
                this.msg.allPrice = this.msg.room_number*this.msg.price;
            }else{
                this.msg.is_invoice = 1;
                this.msg.allPrice = this.msg.room_number*this.msg.price+10;
            }
        },
        select_invoice_type: function(n){
            this.msg.invoice_type = n;
        },
        show_info: function(){
            if(this.msg.is_info){
                this.msg.is_info = 0;
                $('#global-max').hide();
            }else{
                this.msg.is_info = 1;
                $('#global-max').show();
            }
        },
        validation: function(){
            //入住人
            var flag = 1;
            this.msg.person.forEach(function(item,index){
                if(!item || util.trim(item).length<1){
                    flag = 0;
                    util.m.alert('入住人不能为空');
                }
            });
            //联系方式
            if(this.msg.contacter_phone){
                if(!util.regexp.mobile.test(this.msg.contacter_phone)){
                    util.m.alert('联系方式格式错误');
                    flag = 0;
                    return;
                }
            }else{
                util.m.alert('联系方式不能为空！');
                flag = 0;
                return;
            }
            if(this.msg.is_invoice == 1){
                //抬头
                if(this.msg.invoice_title.length<1){
                    util.m.alert('发票抬头不能为空！');
                    flag = 0;
                    return;
                }
                //收件人
                if(this.msg.consignee.length<1){
                    util.m.alert('收件人不能为空');
                    flag = 0;
                    return;
                }
                //手机号
                if(this.msg.phone){
                    if(!util.regexp.mobile.test(this.msg.phone)){
                        util.m.alert('手机号格式错误');
                        flag = 0;
                        return;
                    }
                }else{
                    util.m.alert('手机号不能为空');
                    flag = 0;
                    return;
                }
                //地址
                if(this.msg.address.length<1){
                    util.m.alert('地址不能为空');
                    flag = 0;
                    return;
                }
                //详细地址
                if(this.msg.address_info.length<1){
                    util.m.alert('详细地址不能为空');
                    flag = 0;
                    return;
                }
                //纳税人识别号
                if(this.msg.invoice_type == 2){
                    if(this.msg.taxpayer_number.length<1){
                        util.m.alert('纳税人识别号不能为空');
                        flag = 0;
                        return;
                    }
                }
            }
            if(flag){
                return true;
            }else{
                return false;
            }
        },
        save: function(){
            if(!this.validation()){return false;}
            var _this = this;
            this.is_submit_ing = 1;

            $.ajax({
                url:api_url+'/order/submit',
                type:'post',
                dataType: 'json',
                xhrFields:{withCredentials:true},
                data:{
                    hotel_id: this.msg.hotel_id,//酒店ID
                    hotel_name: this.msg.hotel_name, //酒店名称
                    city_id: this.msg.city_id, //城市ID
                    city_name: this.msg.city_name, //城市名称
                    room_id: this.msg.room_id, //房型房间ID
                    base_room_name:this.msg.roomName,//房型
                    room_name: this.msg.room_name, //房间名
                    ctrip_id: this.msg.ctrip_id, //平台酒店ID
                    ArrivalDate: this.msg.ArrivalDate, //入住时间,格式:2017-09-30
                    DepartureDate: this.msg.DepartureDate, //离开时间,格式:2017-09-30
                    room_number: this.msg.room_number, //入住间数
                    person: this.msg.person.join(','), //入住人信息(a,b,c)
                    contacter_name: this.msg.person[0], //联系人
                    contacter_phone: this.msg.contacter_phone, //联系电话
                    order_requirement: this.msg.order_requirement, //订单要求
                    is_invoice: this.msg.is_invoice, //是否开发票0,不开1,开
                    hotel_address: this.msg.hotel_address, //酒店地址
                    breakfast: this.msg.breakfast, //早餐,格式:单早
                    from_client: 4, //订单来源客户端:1pc, 2ios, 3android, 4mobile, 5公众号
                    RatePlanCategory:this.msg.RatePlanCategory, //携程订单类型；（501：预付订单;16:现付订单）
                    invoice_detail: '订房费'+this.msg.roomAllPrice, //发票明细
                    invoice_title: this.msg.invoice_title, //发票抬头
                    taxpayer_number: this.msg.taxpayer_number, //纳税人识别号
                    consignee: this.msg.consignee, //收件人
                    invoice_type: this.msg.invoice_type, //发票类型,格式:1是个人,2是公司
                    phone: this.msg.phone, //联系电话
                    LastCancelTime:_this.msg.LastCancelTime,
                    address: this.msg.address+this.msg.address_info //收件地址
                },
                success: function(responseData){
                    if(!responseData.errorno){
                        var order_id = responseData.data.order_id;
                        location.href=api_url+"/pay/fast_yeepay?order_id="+order_id+'&h_id='+_this.msg.hotel_id+'&c_id='+_this.msg.ctrip_id;
                    }else{
                        util.m.alert(responseData.msg);
                        _this.is_submit_ing = 0;
                    }
                }
            });
        }

    }
});






