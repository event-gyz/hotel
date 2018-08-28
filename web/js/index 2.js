/**
 * Created by Zhang on 17/8/16.
 */
function getNowFormatDate(ymd,pluspre,day) {//ymd是否需要全部年月日，plusper加减天数，day传入的日期时间戳
    var Day=day ? day : Date.parse(new Date());
    if(pluspre>0){
        Day=Day+86400000*pluspre;
    }else if(pluspre<0){
        Day=Day+86400000*pluspre;
    }
    var date=new Date(Day);
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate =  month + "月" + strDate+"日";
    if(ymd){
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;       
    }
    return currentdate
}
function objKeySort(obj) {
    var newkey = Object.keys(obj).sort();
    var newObj = {};
    for (var i = 0; i < newkey.length; i++) {//遍历newkey数组
        newObj[newkey[i]] = obj[newkey[i]];//向新创建的对象中按照排好的顺序依次增加键值对
    }
    return newObj;//返回排好序的新对象
}
var startTime=getNowFormatDate();
var endTime=getNowFormatDate(false,1);
var cstime=getNowFormatDate(true);
var cetime=getNowFormatDate(true,1);
var Stime=getNowFormatDate(true,-1);
var VM=new Vue({
    el:'#app',
    data: {
        Swiper:[],
        cur_location:'',
        searchRultsLocation:'39.929986,116.395645',
        city_location:'39.929986,116.395645',
        cityId:1,
        cityName:'北京',
        cityContainer:false,
        seachName:false,
        block:'none',
        startTime:startTime,
        endTime:endTime,
        cstime:cstime,
        cetime:cetime,
        ctTime:'',
        cminDate:Stime,
        seachWorld:'',
        ispage:true,
        currentCitySearchData:[],
        otherCitySearchData:{
            key:false,
            info:{}
        },
        searchRultsName:'',
        cookies:[],
        arrcookie:[],
        day:'1',
        sWeek:'今天',
        eWeek:'明天',
        userid:'',
        city:[{'热门城市':[]}],
        userName:''
    },
    mounted:function() {
         var _this = this;
         $.post(api_url+"/hotel/get_nav_pic", function(data){
            _this.Swiper=data.data;
            setTimeout(function(){
                var mySwiper = new Swiper('.swiper-container',{
                    autoplay: 5000,
                    pagination : '.swiper-pagination'
                });
            },500);
            $('#main-box').show();
            $('#global_login').hide();
         });
         _this.getData('北京');
         _this.initdate();
         _this.getCookie('history',true);

        var storage = window.localStorage;
        var token=storage.getItem("token") ;
        if(!token){ 
            $.fn.cookie('user_id', '0', { expires: -8, path:'/' , domain: '.eventown.com'});
            $.fn.cookie('trace_sid','0',{  expires: -8, path:'/' , domain: '.eventown.com'});
        }
        this.userid=$.fn.cookie('user_id');
         if(_this.userid!=null){
             _this.getUserInfo();
         }
        
    },
    methods:{
        getData:function(data){//获取城市列表数据
            var _this=this;
            $.ajax({
                url: api_url+'/place/get_city_list',
                dataType: 'json',
                success: function(res) {
                    _this.cityHot(res.data)   
                },
                error:function(){
                    $.alert('加载失败，请尝试刷新！');
                }
            });
        },
        cityHot:function(data){
            var _this=this;
            var ta=_this.city;
            for(var i in data){
               for(var s=0;s<ta.length;s++){
                      if(data[i].hot){
                        ta[s]['热门城市'].push(data[i]);
                      }else{
                        if(ta[s][data[i].abcd]==undefined){
                                ta[s][data[i].abcd]=[];
                        }
                        ta[s][data[i].abcd].push(data[i]);
                      }
               }
            }  
            _this.city[0]=objKeySort(_this.city[0]);
        },
        getUserInfo:function(){
            var _this=this;
            $.ajax({
                url: api_url+'/user/get_user_info',
                type:'post',
                dataType: 'json',
                xhrFields:{withCredentials:true},
                success: function(res) {
                   if(res.data.nick_name==null && res.data.true_name==null && res.data.user_name==null){
                        $.fn.cookie('user_id', '0', { expires: -8, path:'/' , domain: '.eventown.com'});
                        $.fn.cookie('trace_sid','0',{ expires: -8, path:'/' , domain: '.eventown.com'});
                   }else{
                       if(res.data.nick_name!=''){
                           _this.userName=res.data.nick_name;  
                       }else{
                           _this.userName=res.data.true_name;                
                       }
                   }
                },
                error:function(){
                    $.alert('加载失败，请尝试刷新！');
                }
            });
        },
        cityList:function(){
            this.ispage=false;
            this.block='block';
            this.cityContainer=true;
        },
        cityListBack:function(){
            this.ispage=true;
            this.cityContainer=false;
            this.block='none';
        },
        selectCity:function(id,name,location){
            this.ispage=true;
            this.cityId=id;
            this.cityName=name;
            this.cityContainer=false;
            this.block='none';
            this.city_location=location;
            this.searchRultsLocation=location;
            this.cur_location='';
        },
        initdate:function(){
            var _this=this;
            $("#data-start").calendar({//开始日期
                value: [_this.cstime],
                minDate: [_this.cminDate],
                maxDate: moment().add(29, 'day').format('YYYY-MM-DD'),
                dateFormat: 'mm月dd日',
                onChange:function(p, values, displayValues){
                     _this.cetime=getNowFormatDate(true,1,displayValues[0]);
                     _this.cstime=getNowFormatDate(true,0,displayValues[0]);
                     _this.endTime=getNowFormatDate(false,1,displayValues[0]);
                     _this.ctTime=getNowFormatDate(true,0,displayValues[0]);
                     _this.startTime=getNowFormatDate(false,0,displayValues[0]);
                     $("#data-end").calendar("destroy");//销毁结束日历对象
                     $("#data-end").calendar({
                        value: [_this.cetime],
                        minDate: [_this.ctTime],
                         maxDate: moment().add(30, 'day').format('YYYY-MM-DD'),
                        dateFormat: 'mm月dd日',
                        onChange:function(ep, evalues, edisplayValues){
                            _this.cetime=getNowFormatDate(true,0,edisplayValues[0]);
                            _this.endTime=getNowFormatDate(false,0,edisplayValues[0]);
                            _this.countDate();
                        }
                     }); 
                     _this.countDate();
                }
            });
            $("#data-end").calendar({//结束日期
                value: [_this.cetime],
                minDate: [_this.cetime],
                maxDate: moment().add(30, 'day').format('YYYY-MM-DD'),
                dateFormat: 'mm月dd日',
                onChange:function(ep, evalues, edisplayValues){
                    _this.cetime=getNowFormatDate(true,0,edisplayValues[0]);
                    _this.endTime=getNowFormatDate(false,0,edisplayValues[0]);
                    _this.countDate();
                }
            }); 
        },
        countDate:function(){
            var Tday=new Date();
            var Stday=Date.parse(Tday);
            var Start=Date.parse(new Date(this.cstime));
            var Eed=Date.parse(new Date(this.cetime));
             if(parseInt(Start-Stday)<0){
                this.sWeek="今天"
             }else if(parseInt(Start-Stday)<86400000){
                this.sWeek="明天"
             }else{
                var week=(new Date(this.ctTime)).getDay();
                this.sWeek=['周日','周一','周二','周三','周四','周五','周六'][week];
             }
             if(parseInt(Eed-Stday)<86400000){
                this.eWeek="明天"
             }else{
                var week=(new Date(this.cetime)).getDay();
                this.eWeek=['周日','周一','周二','周三','周四','周五','周六'][week];
             }
            this.day=Math.abs(parseInt((Eed - Start)/1000/3600/24));
        },
        citysearch:function(e){//点击搜索酒店
            e.currentTarget.blur()
            this.seachName=true;
            this.ispage=false;
            this.seachWorld='';
            this.currentCitySearchData.length=0;
            this.otherCitySearchData.key=false;
            this.getCookie('history',true);
        },
        searchCancel:function(){
            this.seachName=false;
            this.ispage=true;//取消搜索
        },
        seachFworld:function(cid,val){
            var _this=this;
            if(val==""){
                val="酒店";
            }
            $.post(api_url+"/hotel/search_by_keywords", {'city_id':cid,'key_words':val},function(data){
                if(data.data.length==0 || data.data.currentCitySearchData==undefined)return;
                 _this.currentCitySearchData=data.data.currentCitySearchData;
                 console.log(_this.currentCitySearchData)
                 if(data.data.otherCitySearchData.length==0){
                    _this.otherCitySearchData.key=false;
                 }else{
                    _this.otherCitySearchData.key=true;
                    _this.otherCitySearchData.info=data.data.otherCitySearchData;
                    _this.otherCitySearchData.location=data.data.otherCitySearchData.otherCityInfo.location;
                 }
            });//点击搜索//搜索酒店接口
        },



        seletedItem:function(name,location,c_id,c_name,otherlocation){//选中搜索结果
            if(c_id!=this.cityId){
                this.cityId=c_id;
                this.cityName=c_name;
                this.cur_location = '';
                this.city_location=otherlocation;
            }

            var str;
            //this.city_location = location;
            this.searchRultsName=name; 
            this.searchRultsLocation=location;
            this.seachName=false;
            this.ispage=true;
            this.storageCookie(name,location,c_id,c_name,otherlocation);
        },
        storageCookie:function(name,location,c_id,c_name,otherlocation){//存储
           var _this=this,str;
           str=name+"+"+location+"+"+this.cityId+"+"+this.cityName+"+"+otherlocation+";"
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
            $.fn.cookie('history',_this.cookies);
            this.getCookie('history',true);
        },
        getCookie:function(item,isF){//获取cookie数据
            var cookienow=$.fn.cookie('history');
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
            var cookienow=$.fn.cookie('history'),bool=true;
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
            $.fn.cookie('history','0',{ expires: -1});
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
        searchList:function(n){
            var pathUrl = '';
            if(this.cur_location){
                pathUrl="/hotel/lists?cityId="+this.cityId+"&location="+this.searchRultsLocation+"&startTime="+this.cstime+"&endTime="+this.cetime+"&serchWorld="+this.searchRultsName+"&cur_location="+this.cur_location+"&cityName="+this.cityName;
            }else if(this.city_location){
                pathUrl="/hotel/lists?cityId="+this.cityId+"&location="+this.searchRultsLocation+"&startTime="+this.cstime+"&endTime="+this.cetime+"&serchWorld="+this.searchRultsName+"&city_location="+this.city_location+"&cityName="+this.cityName;
            }else{
                $.alert('地址错误！');
            }
            if(n){
                location.href = pathUrl;
            }

        },
        toList:function(){
            this.searchRultsName=this.seachWorld;
            this.ispage=true;
            this.seachName=false;
            this.searchList(1);
            if(this.searchRultsName!=''){
               this.storageCookie(this.searchRultsName);               
            }
        },
        clearText:function(){
            this.searchRultsName=''
        },
        getCur_location:function(){
            var _this = this;
            //获取当前位置
            var geolocation = new BMap.Geolocation();
            geolocation.getCurrentPosition(function(r) {
                if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                    _this.cur_location = r.point.lat+','+r.point.lng;
                    _this.city_location = '';
                    _this.cityName = r.address.city;
                    _this.searchRultsName = '';
                    _this.searchRultsLocation = '';
                    $.ajax({
                        url: api_url+'/place/get_city_list',
                        dataType: 'json',
                        success: function(res) {
                            if(!res.errorno){
                                var data = res.data;
                                data.forEach(function(item,index){
                                   if(_this.cityName.indexOf(item.name)!=-1){
                                       _this.cityId = item.areaid;
                                       _this.searchList(0);
                                   }
                                });
                            }else{
                                $.alert('请求失败！');
                            }
                        },
                        error:function(){
                            $.alert('加载失败，请尝试刷新！');
                        }
                    });
                }
            }, { enableHighAccuracy: true });
        }
    },
    watch:{
      seachWorld:function(val){
         this.seachFworld(this.cityId,val)
      }  
    }
});