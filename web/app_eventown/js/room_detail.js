

  var getOneInstace = (function() {
        var result;
        return function(fn) {
            return result || (result = fn.apply(this, arguments))
        }
    })()

  var getCssRule=(function(){

                if (csstransforms) {
                   return function(o,x,y){
                    var cssRule = {
                        "top": parseInt(o.elOriginalTop),
                        "left": parseInt(o.elOriginalLeft)
                    }
                    cssRule[csstransforms] = 'translate(' + parseInt(x) + 'px,' + parseInt(y) + 'px)';
                    return cssRule
                }

                } else {
                    return function(o,x,y){

                    return {
                        "top": parseInt(o.elOriginalTop + y),
                        "left": parseInt(o.elOriginalLeft + x)
                    }
                }
                }

            })()

    var csstransforms = (function() {
        var style = document.body.style || document.documentElement.style
        var transEndEventNames = {
            transform: 'transform',
            WebkitTransform: 'webkitTransform',
            MozTransform: 'mozTransform',
            OTransform: 'oTransform oTransform'
        }
        for (var name in transEndEventNames) {
            if (typeof style[name] === 'string') {
                return transEndEventNames[name]
            }
        }
        return false

    })()


// 获取当前时间
    function now() {
        return +new Date();
    }

// 转化为整数
    function toInteger(text) {
        text = parseInt(text);
        return isFinite(text) ? text : 0;
    }

    var Parabola = function (options) {
        this.initialize(options);
    };
    Parabola.prototype = {
        constructor: Parabola,
        /**
         * 初始化
         * @classDescription 初始化
         * @param {Object} options 插件配置 .
         */
        initialize: function (options) {
            this.options = this.options || this.getOptions(options);
            var ops = this.options;
            if (!this.options.el) {
                return;
            }
            this.$el = $(ops.el).get(0);
            this.timerId = null;
            // this.elOriginalLeft = toInteger(this.$el.css("left"));
            // this.elOriginalTop = toInteger(this.$el.css("top"));
            this.elOriginalLeft = toInteger(this.$el.getBoundingClientRect().left);
            this.elOriginalTop = toInteger(this.$el.getBoundingClientRect().top);

            // this.driftX X轴的偏移总量
            //this.driftY Y轴的偏移总量
            if (ops.targetEl) {
                this.driftX = toInteger(ops.targetEl.get(0).offsetLeft) - this.elOriginalLeft;
                this.driftY = toInteger(ops.targetEl.get(0).offsetTop) - this.elOriginalTop;

            } else {
                this.driftX = ops.offset[0];
                this.driftY = ops.offset[1];
            }

            this.duration = ops.duration;
            this.curvature = ops.curvature;

            this.b = ( this.driftY - this.curvature * this.driftX * this.driftX ) / this.driftX;
            //自动开始
            if (ops.autostart) {
                this.start();
            }
        },
        /**
         * 初始化 配置参数 返回参数MAP
         * @param {Object} options 插件配置 .
         * @return {Object} 配置参数
         */
        getOptions: function (options) {
            if (typeof options !== "object") {
                options = {};
            }
            options = $.extend({}, defaultSetting, $(options.el).data(), (this.options || {}), options);

            return options;
        },
        /**
         * 定位
         * @param {Number} x x坐标 .
         * @param {Object} y y坐标 .
         * @return {Object} this
         */
        domove: function (x, y) {

            // // this.$el.css({
            // //     position: "absolute",
            // //     left: this.elOriginalLeft + x,
            // //     top: this.elOriginalTop + y
            // // });

            // return this;
        },
        /**
         * 每一步执行
         * @param {Data} now 当前时间 .
         * @return {Object} this
         */
        step: function (now) {
            var ops = this.options;
            var x, y;
            if (now > this.end) {
                // 运行结束
                x = this.driftX;
                y = this.driftY;
                // this.domove(x, y);
                this.stop();
                if (typeof ops.callback === 'function') {
                    ops.callback.call(this);
                }
            } else {
                //x 每一步的X轴的位置
                x = this.driftX * ((now - this.begin) / this.duration);
                //每一步的Y轴的位置y = a*x*x + b*x + c;   c==0;
                y = this.curvature * x * x + this.b * x;
                // this.domove(x, y);
                if (typeof ops.stepCallback === 'function') {
                    ops.stepCallback.call(this,x,y);
                }
            }
            return this;
        },
        /**
         * 设置options
         *  @param {Object} options 当前时间 .
         */
        setOptions: function (options) {
            this.reset();
            if (typeof options !== "object") {
                options = {};
            }
            this.options = $.extend(this.options,options);
            this.initialize(this.options);
            return this;
        },
        /**
         * 开始
         */
        start: function () {
            var self = this;
            // 设置起止时间
            this.begin = now();
            this.end = this.begin + this.duration;
            if (this.driftX === 0 && this.driftY === 0) {
                // 原地踏步就别浪费性能了
                return;
            }
            /*timers.push(this);
             Timer.start();*/
            if (!!this.timerId) {
                clearInterval(this.timerId);
            }
            this.timerId = setInterval(function () {
                var t = now();
                self.step(t);

            }, 20);
            return this;
        },
        /**
         * 重置
         */
        reset: function (x, y) {
            this.stop();
            x = x ? x : 0;
            y = y ? y : 0;
            this.domove(x, y);
            return this;
        },
        /**
         * 停止
         */
        stop: function () {
            if (!!this.timerId) {
                clearInterval(this.timerId);

            }
            return this;
        }
    };
    var defaultSetting = {
        el: null,
        //偏移位置
        offset: [0, 0],
        //终点元素，这时就会自动获取该元素的left、top，设置了这个参数，offset将失效
        targetEl: null,
        //运动的时间，默认500毫秒
        duration: 500,
        //抛物线曲率，就是弯曲的程度，越接近于0越像直线，默认0.001
        curvature: 0.001,
        //运动后执行的回调函数
        callback: null,
        // 是否自动开始，默认为false
        autostart: true,
        //运动过程中执行的回调函数
        stepCallback: null
    };


// 创建抛物线
    function createParabola(el) {
        var rollObj = getOneInstace(function() {
            var $div = $('<div id="rollobj">');
            $div.css({
                "position": "fixed",
                "background-color": "#ff431e",
                "width": "20px",
                "height": "20px",
                "border-radius": "50%",
                "z-index": 9999,
                "overflow": 'hidden'
            }).appendTo($('body'))

            return $div

        })
        animationEnd = false;

        var bool = new Parabola({
            el: el,
            targetEl: $('#cartBar'),
            curvature: 0.00150,
            duration: 300,
            callback: function() {
                rollObj.hide();
                rollObj.css({
                    'transform': 'translate(0,0)',
                    "top": 'auto',
                    "left": 'auto',

                });

                  $('.cartNumber').addClass('bounceIn');
                 setTimeout(function() {
                        $('.cartNumber').removeClass('bounceIn');
                 }, 300)

                animationEnd = true;
                bool = null
            },
            stepCallback: function(x, y) {
              rollObj.show()
                 rollObj.css(getCssRule(bool,x,y))
            }
        });
        bool.start();
    }



    // 联系商家
        $('#cartBar').on('click', '#contact-shop', function() {
            $.modal({
                title: "联系方式",
                text: $('.tel-box').html(),
                buttons: [{
                    text: "",
                    className: "hide"
                }],

            });
        })
     map.disableDragging(); //禁止拖拽

    //日期格式化
Vue.filter('formate', function (date) {

    var now = new Date(date);
    return (now.getFullYear() + '/' +   parseInt(now.getMonth() + 1) + '/' + now.getDate())

})
    Vue.filter('formatBreakfast', function (val) {
        if (val == 1) {
            return '单早'
        }
        if (val == 2) {
            return '双早'
        }
            return '无早'
    
    })

function fomatDate(now){
    return (now.getFullYear() + '/' +   parseInt(now.getMonth() + 1) + '/' + now.getDate())
}

function PrePayDiscount(endNumber){

      if(endNumber>=5 && endNumber <10){
        return 1
      }else if(endNumber>=10){
        return 0
      }else{
        return 2
      }
}

function computedPice (item,index){

   var cPrice=item.price_list[index]
   item.price =cPrice.Price - cPrice.PrePayDiscount
   item.discount = cPrice.PrePayDiscount
}

//购物车
Object.keys = Object.keys || function(obj){//ecma262v5 15.2.3.14
     var a = [];
    for(a[a.length] in obj);
    return a ;
        };

var shopCart={
    version:'0.1',
    store:{},
    addTo:function(data){
        var key =Object.keys(data)[0]
        shopCart.store[key]= data[key]
        shopCart.saveLocal()
    shopCart.showCount()
    },
    removeIt:function(key){
       delete this.store[key]
        this.saveLocal()
        this.changCount()
    },
    showCount:function(){
        var number = 0
        $.each(this.getLocal(),function(k,v){
            number += parseInt( v.split(',')[2]) //第二个为number "32819382,9196,1,2016/9/27,2016/9/28"
        })
         if(RoomsVM){RoomsVM.totalCount=number}
        return number
    },
    getLocal:function(){
        return $.parseJSON(window.localStorage.getItem('cartStor') )|| {};
    },
    saveLocal:function(){
        window.localStorage.setItem('cartStor',JSON.stringify(this.store))
    },
    init:function(){
        if(!window.localStorage){
            alert('您的浏览器不支持本地存储，请更换')
        }
       this.store =this.getLocal();
    }
}
    

    var RoomsVM=null;
    creatRoomVM($room_list);
    function creatRoomVM(data){
        var totalCount = shopCart.showCount()
        $.each(data,function(k,v){
            $.each(v.room_info,function(i,o){
                if(typeof shopCart.getLocal()[o.room_id] !=='undefined' ){
                    o.number = parseInt(shopCart.getLocal()[o.room_id].split(',')[2])
                }else{
                    o.number = 0
                }
                // totalCount+=parseInt(o.number)
                o.price = parseInt(o.price_list[0].Price) - parseInt(o.price_list[0].PrePayDiscount)
                o.discount = o.price_list[0].PrePayDiscount
            })
        })
     RoomsVM=  new Vue({
            el:'body',
            data:{
                roomList:data ,
                dateInput:null,
                totalCount:totalCount
            },
            ready:function(){
                shopCart.init()
            },
            methods:{
                add:function(e,pIndex,index){
                  //创建抛物线
                  createParabola($(e.target))

                    $(e.target).parents('.min-numbox').find('.min-numbox-ant').addClass('min-numbox-in')
                    this.roomList[pIndex].room_info[index].number +=1

                    var endNumber=this.roomList[pIndex].room_info[index].number
                     computedPice(this.roomList[pIndex].room_info[index],PrePayDiscount(endNumber));
                     
                     var room_id =this.roomList[pIndex].room_info[index].room_id;
                     var dataObj={};
                         dataObj[room_id]=room_id+','+place_id+','+ endNumber+ ',' +this.userstartDate+','+this.userendDate
                     shopCart.addTo(dataObj)

                },
                reduce:function(e,pIndex,index){
                    var number=this.roomList[pIndex].room_info[index].number
                    if(number<=1){
                       $(e.target).parents('.min-numbox').find('.min-numbox-ant').removeClass('min-numbox-in')
                    }
                    number-=1
                    this.roomList[pIndex].room_info[index].number = number

                     var room_id =this.roomList[pIndex].room_info[index].room_id;
                        var dataObj={};
                         dataObj[room_id]=room_id+','+place_id+','+ number+ ',' +this.userstartDate+','+this.userendDate
                     shopCart.addTo(dataObj)

                     computedPice(this.roomList[pIndex].room_info[index],PrePayDiscount(number))
                     var room_id = this.roomList[pIndex].room_info[index].room_id
                     if(number==0){
                      shopCart.removeIt(room_id)
                     }

                }
            },
            computed:{
              
                timeLong:function(){
                  return  (new Date(this.dateInput.split('-')[1]) - new Date(this.dateInput.split('-')[0]))/1000/60/60/24 || 1
                },
                userstartDate:function(){
                    if(this.dateInput){
                        localStorage.mstarttime=this.dateInput.split('-')[0];
                        return this.dateInput.split('-')[0]
                    }else if(localStorage.mstarttime!=undefined){
                        return localStorage.mstarttime;
                    }
                    var sd=new Date().getTime();
                    sd+=1000*60*60*24;
                    localStorage.mstarttime=fomatDate(new Date(sd));
                    return fomatDate(new Date(sd));
                },
                userendDate:function(){
                    if(this.dateInput){
                        localStorage.mendtime=this.dataInput.split('-')[1];
                        return this.dateInput.split('-')[1]
                    }else if(localStorage.mendtime!=undefined){
                        return localStorage.mendtime;
                    }
                    var d = new Date().getTime();
                    d +=(1000*60*60*24)*2;
                    localStorage.mendtime=fomatDate(new Date(d));
                    return fomatDate(new Date(d))
                }
            }
        })
    }

    $('#date-input').on('change',function(e,val){
   RoomsVM.dataInput=val
})