/*********
simpleDateRangePicker V 1.1 
author :yaojia
2016.9.26 日 更新
1.修正 getWeeknumber 返回 NAN 

*********/

var simpleDateRangePicker = function(element, options) {

    this.parentEl = 'body';
    this.element = $(element);
    this.separator = "-";
    this.startDate = this.element.val() ? this.element.val().split(this.separator)[0] : "";
    this.endDate = this.element.val() ? this.element.val().split(this.separator)[1] : "";
    this.minDate = new Date();
    this.monthLength = 6, //默认生成最近6月的日历表格
        this.template =
        '<div class="daterangepicker  page-next">' +
        '<header id="header">' +
        '<span class="f-l">'+
        '<a class="close-date">' +
        '<i class="iconfont">&#xe605;</i>' +
        '</a>' +
        '</span>'+
        '<h1 class="text-overflow">选择日期</h1>' +
        '</header>' +
        '<div class="daterangepicker_input">' +
        '<input class="input-mini" type="text"  readonly="readonly" disabled  name="daterangepicker_start" placeholder="入住日期" value="" />' +
        '<span class="date-line">一</span>' +
        '<input class="input-mini" type="text" readonly="readonly" disabled name="daterangepicker_end" placeholder="离店日期"  value="" />' +
        '</div>' +
        '<div class="calendar ">' +
        '</div>' +
        '<div class="tips">' +
        '请选择入住日期' +
        '</div>'
    '</div>';

    this.container = $(this.template).appendTo($(this.parentEl)).hide();


    this.container.find('.calendar')
        .on('click.daterangepicker', '.alive', $.proxy(this.clickDate, this))

    this.container.find('.daterangepicker_btns')

    this.container.find('.date-back').on('click.daterangepicker', $.proxy(this.hide, this))
        // .on('click.daterangepicker', 'button.applyBtn', $.proxy(this.clickApply, this))
        // .on('click.daterangepicker', 'button.cancelBtn', $.proxy(this.clickCancel, this))


    var _this = this;
    this.element.on('click', function() {
        _this.show()

    })

    $(this.container).on('click','.close-date',function () {
      _this.hide()
    })


    //获取初始月

    var now = new Date();

    var cyear = now.getFullYear();
    var cmonth = now.getMonth();



    this.generatorlastMonth()




}


simpleDateRangePicker.prototype = {

    constructor: simpleDateRangePicker,

    getToday: function() {
        var now = new Date();
        return (now.getFullYear() + '/' + now.getMonth() + 1 + '/' + now.getDate())
    },

    show: function() {
        this.container.show();
        this.container.offset().width = this.container.offset().width
        this.container.addClass('page-in');
        this.setTips('start')
    },
    hide: function() {
        var _this = this
        this.container.removeClass('page-in').on('transitionend', function() {
        _this.container.hide();
        _this.container.off('transitionend')
    })


    },

    //生成最近几个月,返回年月的数组

    generatorlastMonth: function() {

        for (var i = 0; i <= this.monthLength; i++) {
            var now = new Date(),
                cmonth = now.getMonth();
            now.setMonth(cmonth + i)
            var year = now.getFullYear();
            var month = now.getMonth();
            this.renderCalendar(year, month)
        };
    },
    setTips: function() {

        if (arguments[0] === 'start') {
            this.container.find('.tips').html('请选择入住日期');

        } else {
            this.container.find('.tips').html('请选择离店日期')
        }

    },
    clickApply: function() {

        this.hide();
        this.element.val(this.startDate + this.separator + this.endDate);

    },
    /*清除日期*/
    clickCancel: function() {
        this.container.find('.calendar .day').removeClass('active')
            .find('.tag').remove()
        this.setCalendarInputVal()

    },

    //设置入住日期 离店日期的值,无参数为清空。有参数为设置

    setCalendarInputVal: function() {

        var arg = arguments;
        if (arg.length == 0) {
            this.container.find('input[name="daterangepicker_start"]').val('');
            this.container.find('input[name="daterangepicker_end"]').val('');
        } else {
            this.container.find('input[name="daterangepicker_start"]').val(this.startDate);
            this.container.find('input[name="daterangepicker_end"]').val(this.endDate);
        }



    },

    setStart: function(dateStr, $target) {
        this.removeTag();
        $target.addClass('active');
        $('<span class="tag">').html('入住日期').appendTo($target);
        this.startDate = dateStr;
        this.container.find('input[name="daterangepicker_start"]').val(dateStr);
        this.setTips('end') 
    },
    removeTag: function() {
        this.container.find('td').removeClass('active').find('.tag').remove()
    },
    //string to Date
    dateConvert: function(s) {
        var arr = s.match(/\d+/g);
        return new Date(arr[0], arr[1] - 1, arr[2])
    },

    formateDate:function(time){
        var d=new Date(time);
        return d.getFullYear()+'/'+(d.getMonth()+1)+'/'+d.getDate();
    },

    clickDate: function(e) {
        var tarname = e.target.tagName.toUpperCase();
        var $target = tarname == 'TD' ? $(e.target) : $(e.target).parent('td');
        var dateStr = $target.attr('id');
        var currday = this.dateConvert($target.attr('id'));

        if (this.startDate && this.endDate) {
            this.startDate = this.endDate = ''

            this.element.val('');
            console.log('设置日期为','null')
            this.removeTag()
        }
        $target.addClass('active');
        //设置开始时间
        //已设置开始时间，如果选择的时间小于开始时间，继续设置为开始时间。
        console.log('this.startDate',this.startDate,currday.getTime(),'======',this.formateDate(currday.getTime()));

        if (this.startDate == '' || currday.getTime() < this.dateConvert(this.startDate).getTime()) {
            console.log('this.setStart',dateStr,$target);
            this.setStart(dateStr, $target)
            return
        }

        localStorage.mstarttime=this.formateDate(this.startDate);

        //设置离店日期 
        if (this.startDate != '' && this.endDate == '') {
            this.endDate = dateStr;
            this.container.find('input[name="daterangepicker_end"]').val(dateStr);
            $('<span class="tag">').html('离店日期').appendTo($target);
            localStorage.mendtime=this.endDate;
            this.element.val(this.startDate + this.separator + this.endDate);
            this.element.trigger('change',this.element.val());
            this.hide();
        }
    },

    hightLightRangDays: function(start, end) {

        var s = new Date(start);
        var e = new Date(end);


    },
    checkminDate: function(y, m, d) {

        var minDate = this.minDate.setHours(0, 0, 0, 0);
        var foday = new Date(y, m, d).setHours(0, 0, 0, 0);

        if (foday < minDate) {

            return true
        } else if (foday >= minDate) {
            return false
        }

    },
    renderCalendar: function(year, month) {

        // 获取任意年月天数   
        var getMDays = function(y, m) {

            var mday = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
            if ((y % 4 == 0 && y % 100 != 0) || y % 400 == 0) //判断是否是闰月 
                mday[1] = 29;
            return mday[m];
        }

        var getWeekNumber = function(y, m, d) {
            //new Date 参数月份不能为0，而是1开始
            m=m+1;
            return new Date(y + '/' + m+ '/' + d).getDay()
        }

        var daynumber = getMDays(year, month); //当月天数 
        var firstnumber = getWeekNumber(year, month, 1); //当月第一天星期 
        var lastnumber = getWeekNumber(year, month, daynumber); //当月最后一天星期 
        //如果input有值，那么读取并渲染到calendar面板
        if (this.startDate && this.endDate) {
            this.setCalendarInputVal(true)
        }


        var day = 1;
        var calendar = '';
        calendar += "<h4>" + year + "年" + (month + 1) + "月</h4>"
        calendar += "<table>";
        calendar += "<tr>";
        calendar += "<td>日</td>";
        calendar += "<td>一</td>";
        calendar += "<td>二</td>";
        calendar += "<td>三</td>";
        calendar += "<td>四</td>";
        calendar += "<td>五</td>";
        calendar += "<td>六</td>";
        calendar += "</tr>";
        calendar += "<tr>";

        var i = 0;

        for (i = 0; i < firstnumber; i++) //第一个星期 ,第一天是星期几。

        {
            calendar += "<td></td>";
        }

        for (i = firstnumber; i < 7; i++) {
            if (this.checkminDate(year, month, day)) {
                var className = "day disabled"
            } else {
                var className = "day alive"
            }
            calendar += '<td class="' + className + '" id="' + year + '/' + (month + 1) + '/' + day + '"><em>' + day + '</em></td>';
            day++;
        }

        calendar += "</tr>";
        // 计算需要多少行 .开始星期+本月天数
        var rows = Math.ceil((daynumber + firstnumber) / 7);


        for (var wk = 0; wk < rows - 1; wk++) {

            calendar += "<tr>"

            for (var d = 0; d < 7; d++) {

                if (day > daynumber) {

                    calendar += "<td></td>";

                } else {

                    if (this.checkminDate(year, month, day)) {
                        var className = "day disabled"
                    } else {
                        var className = "day alive"
                    }
                    calendar += '<td class="' + className + '" id="' + year + '/' + (month + 1) + '/' + day + '"><em>' + day + '</em></td>';

                    day++


                }

            };



            calendar += "</tr>"


        }



        calendar += "</table>";





        $('<div class="calendar-table ">').html(calendar).appendTo(this.container.find('.calendar'))



    }

}


$.fn.simpleDateRangePicker = function(options, callback) {
    this.each(function() {
        var el = $(this);
        if (el.data('simpleDateRangePicker'))
            el.data('simpleDateRangePicker').remove();
        el.data('simpleDateRangePicker', new simpleDateRangePicker(el, options, callback));
    });
    return this;
};

// return simpleDateRangePicker;



$(function() {
    $('input[name="daterange"]').simpleDateRangePicker();
});

