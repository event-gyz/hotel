(function () {

    //自动计算。。
    $('.count').on('keyup paste change', function () {
        $('#totalNum').val(total_number().toFixed(2));
    });

    function total_number() {
        var number = 0;
        $('.count').each(function (k, v) {

            var val = $(v).val();
            if (val == '' || isNaN(val) || val == null || typeof val == 'undefined') {
                val = '0'
            }

            val = val.replace(/[^\d\.]/g, "").replace(/^\./g, "").replace(/\.\d*\./g, ".").replace(/(\.\d{2,2})\d*/g, "$1").replace(/^[0]{1}/g, '');
            $(v).val(val);
            number += +val;

        });

        return number;
    }


    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // 文件接收服务端。
        server: '/rfp/upload_file',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#uploadbtn',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    // 当有文件添加进来的时候
    uploader.on('fileQueued', function (file) {
        var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<img>' +
                '</div>'
            ),
            $img = $li.find('img');


        // $list为容器jQuery实例
        $('#fileList').append($li);

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr('src', src).width(90).height(90);
        }, 90, 90);

        $percent = $li.find('.progress span');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<p class="progress"><span style="width:5%"></span></p>')
                .appendTo($li)
                .find('span');
        }


    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.find('.progress span');
        $percent.css('width', percentage * 100 + '%');
    });

    var pre_files = [];
    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, res) {

        var $li = $('#' + file.id),
            $success = $li.find('div.success');

        // 避免重复创建
        if (!$success.length) {
            $success = $('<div class="success"></div>').appendTo($li, res);
        }

        $success.html('上传成功 <a href="#" class="delete show-toast"><i class="icon iconfont ">&#xe654;</i></a>');
        // console.log(res.path);
        // console.log(file);
        pre_files[file.id] = res.path;

        // alert(res.path);

        $li.find('img').attr('src2', '/' + res.path);


        // console.log(pre_files);
        //$('<input  name="file[]" type="hidden" value="' + res.data.url + '">').appendTo($li);

    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.html('上传失败 <a href="#" class="delete show-toast"><i class="icon iconfont ">&#xe654;</i></a>');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress').remove();
    });

    $('#fileList').on('click.del', '.delete', function () {

        var id = $(this).parents('.file-item').attr('id');
        $(this).parents('.file-item').remove();

        uploader.removeFile(id);
        delete pre_files[id];
    });


    function checkStart() {
        var ischeck = false;

        $('.rating').each(function (k, v) {
            if ($(v).val() != 0) {
                ischeck = true;
            }
        });
        return ischeck;
    }

    function checkPicture() {
        var str_url = '';
        for (var each in pre_files) {
            str_url += pre_files[each] + ',';
        }
        if (str_url == '') {
            return false;
        }
        $('#submit_files').val(str_url);

        return true;
    }


    function checkcomment() {
        return $('#content_evaluate').val().length > 10;
    }


    function checkMoney() {
        return parseInt($('#totalNum').val()) > parseInt($('#prev').text());
    }

    function checktotalNum() {
        return $('#totalNum').val() > 0
    }

    function checkinPeople() {
        var g = /^[1-9]*[1-9][0-9]*$/;
        return $('#checkinPeople').val() == '' || $('#checkinPeople').val() == null || !g.test($('#checkinPeople').val());
    }


    var wait = 5;

    function time() {
        if (wait == 0) {
            $.closeModal(modal_two);

            window.location.href = "/memo_defray_detail.html";
        } else {
            $(".swiper-pagination").find('span').html(wait);
            wait--;
            setTimeout(function () {
                    time()
                },
                1000);
        }
    }


    function submitform() {
        myajaxSubmit();
    }

    //获取格式化的时间
    function getNowFormatDate() {
        var date = new Date();
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();

        var strHour = date.getHours();
        var strMin = date.getMinutes();
        var stSec = date.getSeconds();


        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }

        if (strHour >= 0 && strHour <= 9) {
            strHour = "0" + strHour;
        }

        if (strMin >= 0 && strMin <= 9) {
            strMin = "0" + strMin;
        }

        if (strDate >= 0 && stSec <= 9) {
            stSec = "0" + stSec;
        }
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + strHour + seperator2 + strMin
            + seperator2 + stSec;
        return currentdate;
    }


    var modal_two = '';

    $(document).on('click', '.open-confirm', function () {

        if (checkinPeople()) {
            return $.alert('请输入签到人数');
        }


        if (!checktotalNum()) {
            return $.alert('请输入实际支出金额');
        }


        if (!checkPicture()) {
            return $.alert('请上传水单照片');
        }


        if (!checkStart()) {
            return $.alert('请对酒店服务进行评分');
        }

        // if (!checkcomment()) {
        //     return $.alert('请输入评价描述，不少于10个字哦');
        // }


        if (checkMoney()) {

            $.modal({
                title: '超预算提醒！',
                text: '已超预算，无法跳转支付，请联系费用管理员，并通知会唐系统<div style="display:block">010-56296960</div>',
                buttons: [{
                    text: '是(Y)',
                    onClick: function () {
                        submitform();
                    }
                }, {
                    text: '否(N)',
                    onClick: function () {
                        return;
                    }
                }]
            });

        } else {

            var modal = $.modal({
                title: '<div class="swiper-slide"><i class="icon iconfont orange_color" style="font-size:1rem;">&#xe65d;</i></div>',
                text: '请仔细检查实际支出及水单，确认后则无法再次修改，是否确认提交？',
                buttons: [{
                    text: '是(Y)',
                    bold: true,
                    onClick: function () {
                        submitform();
                    }
                }, {
                    text: '否(N)'
                }]
            });

        }

    });

    $(".star-default").rating({
        size: 'xt',
        starCaptions: {
            1: '很差',
            2: '不满',
            3: '一般',
            4: '满意',
            5: '很赞'
        },
        clearCaption: '',
        showClear: false
    });

    function show_loading(msg) {
        $.showPreloader(msg);
    }

    function myajaxSubmit() {
        $.ajax({
            method: 'post',
            url: '/index.php/rfp/save_memo_info',
            timeout: 20000,
            beforeSend: function () {
                // 显示loading
                show_loading('请求中...');
            },
            data: $('#submit_form').serialize(),
            success: function (data) {
                // 后续处理
                var is_success = data.errorno === 0 ? true : false;
                if (is_success) {
                    $.alert(data.msg, function () {
                        window.location.href = data.data.jump_url;
                    });
                } else {
                    $.alert(data.msg);
                }
            },
            complete: function () {
                $.hidePreloader();// 隐藏loading
            },
            error: function () {
                $.alert("请求出错了,请稍候再试");
            }
        });
    }

})();