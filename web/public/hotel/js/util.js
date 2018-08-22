/**
 * Created by Zhang on 17/7/17.
 */
var css = "#global-alert{position: fixed;left: 50%;top: 50%;background: #fff;padding:20px 30px;font-size: 16px;z-index:99999;display:inlin-block;display:none;}#global-alert-mask,#global-confirm-mask{display: none;position: fixed;left: 0;top: 0;z-index: 10000;width: 100%;height: 100%;background: #000;opacity: 0.8;}#global-confirm{position: fixed;left: 50%;top: 50%;background: #fff;padding:20px 30px;font-size: 16px;z-index:99999;border:1px solid #ccc;}.confirm-title{line-height:23px;margin-bottom:50px;text-align:center;font-size:16px;}.confirm-button{text-align:center;padding-top:10px;}.confirm-button button{margin:0 25px;padding:5px 15px;cursor:pointer;}#m-global-alert,#m-global-confirm{position: fixed;z-index: 99999;left: 50%;top: 40%;width: 86%;margin-left: -43%;background: #fff;border-radius: 10px;}.m-global-alert-title,.m-global-confirm-title{font-size: 18px;border-bottom: 1px solid #eee;padding: 20px 20px;line-height: 25px;text-align: center;}.m-global-alert-button {font-size: 20px;height: 45px;line-height: 45px;text-align: center;color: #40CE7D;}.m-global-confirm-button{position:relative;height:45px;overflow:hidden;width:100%;}.m-confirm-cancel{float:left;width:50%;height:45px;text-align:center;font-size:20px;border-right:1px solid #eee;line-height:45px;}.m-confirm-submit{float:right;width:49.5%;height:45px;line-height:45px;text-align:center;font-size:20px;color: #40CE7D;}";

$('head').append('<style type="text/css">'+css+'</style>');
var util = {
    //正则表达式
    regexp: {
        "tel": /^(\({0,1}\d{3,4})\){0,1}(-){0,1}(\d{7,8})$/,
        "mail": /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/,
        "mobile": /^1[0-9]{10}$/,
        "number": /^[0-9]*$/,
        "float": /^[+]{0,1}(\d+)$|^[+]{0,1}(\d+\.\d+)$/,
        "url": /http:\/\/([\w-]+\.)+[\w-]+(\/[\\w\- .\/?%&=]*)?/,
        "time": /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/,
        "idCard": /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/
    },
    //去除字符串所以空格
    "trim": function(str){
        var reg = /\s/g;
        str = str&&str.replace(reg,'');
        return str;
    }
};

/**
 * 自定义移动端的alert
 */
util.m={};
util.m.alert = function(text,fn){
    if($('#m-global-alert').length){
        $('#m-global-alert .m-global-alert-title').html(text);
    }else{
        var html = '<div id="m-global-alert"><div class="m-global-alert-title">'+text+'</div><div class="m-global-alert-button">确 定</div></div>';
        $('body').append(html);
    }
    if(!$('#global-alert-mask').length){
        $('body').append('<div id="global-alert-mask"></div>');
    }
    $('#global-alert-mask').show();
    $('#m-global-alert').show();
    $('#m-global-alert .m-global-alert-button').unbind('click').click(function(){$('#global-alert-mask').hide();$('#m-global-alert').hide();if(fn){fn()}});
};
/**
 * 自定义移动端的confirm
 */
util.m.confirm = function(text,cancel,submit){
    if($('#m-global-confirm').length){
        $('#m-global-confirm .m-global-confirm-title').html(text);
    }else{
        var html = '<div id="m-global-confirm"><div class="m-global-confirm-title">'+text+'</div><div class="m-global-confirm-button"><p class="m-confirm-cancel">取 消</p><p class="m-confirm-submit">确 定</p></div></div>';
        $('body').append(html);
    }
    if(!$('#global-alert-mask').length){
        $('body').append('<div id="global-alert-mask"></div>');
    }
    $('#global-alert-mask').show();
    $('#m-global-confirm').show();
    $('#m-global-confirm .m-confirm-cancel').unbind('click').click(function(){$('#global-alert-mask').hide();$('#m-global-confirm').hide();cancel();});
    $('#m-global-confirm .m-confirm-submit').unbind('click').click(function(){$('#global-alert-mask').hide();$('#m-global-confirm').hide();submit();});
};

