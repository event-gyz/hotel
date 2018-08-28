/**
 * Created by Zhang on 17/8/16.
 */


$('#input-search').click(function(){
    $('#searchPage').show();
    $('#searchPage').offset().width = $('#searchPage').offset().width;
    $('#searchPage').addClass('page-in');
});
$('#searchCancel').on('click',function(){
    $('#searchPage').removeClass('page-in').on('transitionend', function() {
        $(this).hide();
        $(this).off('transitionend')
    })
});



var VM = new Vue({
    el:'#app',
    data:{
        locations:[],
        position_name: '酒店位置',
        price_name:'星级／价格',
        sort_name:'排序',
        isMore: 0,
        start_date:'',
        end_date:'',
        metro_line:0,
        price_from:0,
        price_to:1500,
        cur_location:'',
        query_params: {
            location:'',
            city_id:'1',
            city_name:"北京",
            key_words:'',
            star_rate:'',
            change_location:'',
            price:'',
            roomMinPrice:'',
            starSort:'',
            position:'',
            current_location:'',
            page:1
        },
        isPosition: false,
        isSort: false,
        isStar: false,
        isMask: false,
        position:[],
        line:[],
        msg:[],
        isSearch:false,
        seachWorld:'',
        currentCitySearchData:[],
        otherCitySearchData:{
            key:false,
            info:{}
        },
        searchRultsName:'',
        searchRultsLocation:'',
        cookies:[],
        arrcookie:[]

    },
    computed: {

    },
    mounted: function(){
        var starch = decodeURI(window.location.search.substr(1));
        var params = starch.split('&');
        var paramsObj = {};
        params.forEach(function(item,index){
            var k = item.split('=')[0];
            var v = item.split('=')[1];
            paramsObj[k] = v;
        });
        this.query_params.city_id = paramsObj.cityId;
        this.query_params.key_words = paramsObj.serchWorld;
        this.query_params.change_location = paramsObj.city_location || paramsObj.location;
        this.query_params.city_name = paramsObj.cityName;
        this.query_params.current_location = paramsObj.cur_location;
        this.start_date = paramsObj.startTime;
        this.end_date = paramsObj.endTime;
        var _this = this;
        this.getCookie('history',true);
        this.$nextTick(function () {
            _this.queryList();
            var x = $("#range_02").ionRangeSlider({
                type: "double",
                min: 0,
                max: 1500,
                from: 0,
                to: 1500,
                onStart: updateInputs,
                onChange: updateInputs
            });
            function updateInputs (data) {
                _this.price_from= data.from;
                _this.price_to= data.to;
            }

        });
    },
    methods: {

        goBack: function(){
            location.href='/index/index';
        },
        clearText: function(){
            this.query_params.key_words = '';
            this.query_params.page = 1;
            this.queryList();
        },
        //加载更多
        set_page: function(){
            this.query_params.page++;
            this.queryList(1);
        },
        //酒店类型的背景颜色
        setColor: function (x) {
            return 'color'+x;
        },
        //酒店星级
        starShow: function (n) {
            var arr = [];
            if(this.query_params.star_rate.length){
                arr = this.query_params.star_rate.split(',');
            }
            if(n){
                if(arr.indexOf(n.toString()) != -1){
                    return 'cur';
                }
            }else{
                if(arr.length == 0){
                    return 'cur';
                }
            }
        },
        setStar: function(n){
            var arr = [];
            if(this.query_params.star_rate.length){
                arr = this.query_params.star_rate.split(',');
            }
            if(n){
                if(arr.indexOf(n.toString()) != -1){
                    arr.splice(arr.indexOf(n.toString()),1);
                }else{
                    arr.push(n.toString());
                }
                if(arr.length == 4){
                    this.query_params.star_rate = '';
                }else{
                    this.query_params.star_rate = arr.join(',');
                }
            }else{
                this.query_params.star_rate = '';
            }
            this.query_params.page = 1;
        },
        //显示酒店位置下拉
        showHotelPosition: function(){
            this.isPosition = true;
            this.isMask = true;
            this.isStar = false;
            this.isSort = false;
        },
        //显示星级和价格下拉
        showStar: function(){
            this.isStar = true;
            this.isMask = true;
            this.isPosition = false;
            this.isSort = false;
        },
        //显示排序下拉
        showStore: function(){
            this.isSort = true;
            this.isMask = true;
            this.isPosition = false;
            this.isStar = false;
        },
        //排序搜索
        sortSearch: function(type,val,name){
            if(type == 'star'){
                this.query_params.roomMinPrice = '';
                this.query_params.starSort = val;
            }else if(type == 'price'){
                this.query_params.roomMinPrice = val;
                this.query_params.starSort = '';
            }else{
                this.query_params.roomMinPrice = '';
                this.query_params.starSort = '';
            }
            this.sort_name = name;
            this.isMask = false;
            this.isSort = false;
            this.query_params.page = 1;
            this.queryList();
        },
        show_class:function(name){
            $('.select-position>p').removeClass('cur');
            $('.'+name).addClass('cur');
            $('.show-box').hide();
            $('#'+name).show();
        },
        //酒店位置搜索
        query: function(type,id,name,location){

            this.query_params.position = type+'_id-'+id;
            this.query_params.location='';

            this.query_params.page = 1;
            this.position_name = name;
            this.isMask = false;
            this.isPosition = false;
            this.queryList();
        },

        hide_mask: function(){
            this.isStar = false;
            this.isMask = false;
            this.isPosition = false;
            this.isSort = false;
        },
        //清空价格选项
        priceClear: function(){
            this.query_params.page = 1;
            this.isStar = false;
            this.isMask = false;
            this.price_from = 0;
            this.price_to = 1500;
            this.query_params.star_rate = '';
            this.query_params.price = '';
            var slider = $("#range_02").data("ionRangeSlider");
            slider.update({
                from: 0,
                to: 1500
            });
            this.queryList();
        },
        //关闭价格选项
        priceSubmit: function(){
            this.query_params.page = 1;
            this.isStar = false;
            this.isMask = false;
            if(this.price_from!=0 || this.price_to!=1500){
                this.query_params.price = this.price_from+'-'+this.price_to;
            }else{
                this.query_params.price = '';
            }
            this.queryList();
        },
        set_listMap: function(){
            $('#listmap').submit();
        },
        //请求酒店数据
        queryList: function(n){
            var _this = this;
            var data=this.query_params;
            data.start_date=this.start_date;
            data.end_date=this.end_date;
            this.locations = JSON.stringify(data);
            $.ajax({
                url:'/index/lists',
                type:'post',
                dataType: 'json',
                data:this.query_params,
                success: function(responseData){
                    if(!responseData.errorno){
                        if(n){
                            _this.msg = _this.msg.concat(responseData.data.rows);
                        }else{
                            _this.msg = responseData.data.rows;
                        }
                        if(responseData.data.total>_this.query_params.page*10){
                            _this.isMore = 1;
                        }else{
                            _this.isMore = 0;
                        }
                    }else{
                        alert(responseData.msg);
                    }
                }
            });
        },


        //关键词搜索
        worldSearch:function(){
            this.hide_mask();
            this.isSearch=true;
        },
        seachFworld:function(cid,val){
            var _this=this;
            if(val==""){
                val="酒店";
            }
            var url = '/hotel/search_by_keywords';
            $.post(url, {'city_id':cid,'key_words':val},function(data){
                if(data.data.length==0 || data.data.currentCitySearchData==undefined)return;
                 _this.currentCitySearchData=data.data.currentCitySearchData;
                 if(data.data.otherCitySearchData.length==0){
                    _this.otherCitySearchData.key=false;
                 }else{
                    _this.otherCitySearchData.key=true;
                    _this.otherCitySearchData.info=data.data.otherCitySearchData;
                    _this.otherCitySearchData.location=data.data.otherCitySearchData.otherCityInfo.location;
                 }
            });//点击搜索//搜索酒店接口
        },
        searchCancel:function(){
            this.isSearch=false;//取消搜索
            this.seachWorld="";
        },
        seletedItem:function(name,location,c_id,c_name,otherlocation){//选中搜索结果
            if(c_id!=this.query_params.city_id){
                this.query_params.city_id=c_id;
                this.query_params.city_name=c_name;
                this.query_params.change_location=otherlocation;
            }

            var str;
            this.query_params.key_words=name;
            //this.query_params.change_location=location;

            this.position_name = '酒店位置';
            this.sort_name='排序';
            this.query_params.star_rate = '';
            this.query_params.location = '';
            this.query_params.roomMinPrice = '';
            this.query_params.price = '';
            this.query_params.starSort = '';
            this.query_params.position ='';
            this.query_params.page = 1;
            var slider = $("#range_02").data("ionRangeSlider");
            slider.update({
                from: 0,
                to: 1500
            });
            this.line = [];
            this.queryList();
            this.isSearch=false;
            this.seachWorld='';
            this.storageCookie(name,location,c_id,c_name,otherlocation)
        },
        storageCookie:function(name,location,c_id,c_name,otherlocation){//存储
            var _this=this,str;
            str=name+"+"+location+"+"+this.query_params.city_id+"+"+this.query_params.city_name+"+"+otherlocation+";"
            if(this.cookies.length==0){//给cookie第一次赋值
               this.cookies=this.getCookie('history');
               if(this.cookies==null){
                  this.cookies='';
               }
            }
            if(!this.cookieFn('history',str)){
                return;//给cookie去空和重复数据
            } else{
                this.cookies=(this.cookieFn('history',str)==true ? "" : this.cookieFn('history',str));
            }
            this.cookies=str+this.cookies;
            $.cookie('history',this.cookies);
            this.getCookie('history',true);
        },
        getCookie:function(item,isF){//获取cookie数据
            var cookienow=$.cookie(item);
            if(cookienow==null){
                return;
            }
            if(isF){
                var arr=cookienow.split(';'),nArr=[];
                arr=this.arrTrim(arr);
                for(var i=0;i<arr.length;i++){
                   var data={'name':(arr[i].split('+')[0]),'location':(arr[i].split('+')[1]),'cid':(arr[i].split('+')[2]),'cname':(arr[i].split('+')[3]),'otherlocation':(arr[i].split('+')[4])};
                   nArr.push(data);
                }
                this.arrcookie=nArr;
            }
            return cookienow;
        },
        cookieFn:function(item,str){//处理cookie重复数据，始终保持5条数据
            var cookienow=$.cookie('history'),bool=true;
            if(cookienow=="" || cookienow==null){//判断cookie是否为空
                return bool;
            } 
            var arr=cookienow.split(';');
            arr=this.arrTrim(arr);
            str=str.replace(';','');
            for(var i=0;i<arr.length;i++){
                if(str==arr[i]){
                  bool=false;
                }
            }
            if(arr.length>4){
                arr.length=4
            }
            cookienow=arr.join(';');
            if(bool){
                return cookienow;
            }else{
                return bool; 
            }
        },
        clearHistory:function(){//删除历史cookie
            $.cookie('history','0',{ expires: -1});
            this.arrcookie.splice(0,this.arrcookie.length);
        },
        arrTrim:function(arr){//去掉数组
            for(var i = 0;i<arr.length;i++){
                if(arr[i]==''|| arr[i]==null || typeof(arr[i])==undefined){
                    arr.splice(i,1);
                    i=i-1;
                }
            }
            return arr;
        },
        tosearch:function(){
            this.query_params.key_words=this.seachWorld;
            this.serchWorld='';
            if(this.query_params.key_words!=''){
               this.storageCookie(this.query_params.key_words);
            }
            this.queryList();
            this.isSearch=false;
        }
    },
    watch:{
      seachWorld:function(val){
         this.seachFworld(this.query_params.city_id,val)
      }  
    }
});

