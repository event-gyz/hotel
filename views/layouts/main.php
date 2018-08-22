<?php
/* @var $this \yii\web\View */
/* @var $content string */
// use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
// AppAsset::register($this);
$menu = array(
    'admin'           =>array(
        'admin'       =>array('index','update'),
    ),
    'users' => [
        'users',
    ],


);
//function isActive($menuVal=array(),$returnBool=false){
//    $controllerId = strtolower( Yii::$app->controller->id );
//    $actionId     = strtolower( Yii::$app->controller->action->id );
//    if( isset( $menuVal[$controllerId] ) ){
//        if( in_array( $actionId, $menuVal[$controllerId]) ){
//            return $returnBool ? true : 'active';
//        }
//    }else if( in_array( $controllerId, $menuVal) ) {
//        return $returnBool ? true : 'active';
//    }
//    return $returnBool ? false : '';
//}
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>"  class="app">
        <head>
            <meta charset="<?= Yii::$app->charset ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="expires" content="0">
            <meta http-equiv="pragma" content="no-cache">
            <meta http-equiv="cache-control" content="no-cache">
            <meta name="msapplication-config" content="none"/>
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <link rel="stylesheet" href="//at.alicdn.com/t/font_og13f713pkg1fw29.css">
            <?=Html::cssFile('@web/css/font.css')?>
            <?=Html::cssFile('@web/css/font_all.css')?>
            <?=Html::cssFile('@web/css/app.v2.css')?>
            <?=Html::cssFile('@web/css/style.css')?>
            <?=Html::cssFile('@web/css/webuploader/webuploader.css')?>
            <?=Html::jsFile('@web/js/app.v2.js')?>
            <?=Html::jsFile('@web/js/html5shiv.js')?>
            <?=Html::jsFile('@web/js/respond.min.js')?>

            <?=Html::jsFile('@web/js/jquery-1.8.2.js')?>

            <?=Html::jsFile('@web/js/plugins/select2/select2.full.js')?>


            <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
            <?=Html::jsFile('@web/js/plugins/webuploader/webuploader.min.js')?>

            <?=Html::jsFile('@web/js/plugins/suggest/bootstrap-suggest.min.js')?>
            <?=Html::jsFile('@web/plugins/datetimepicker/bootstrap-datetimepicker.min.js')?>
            <?=Html::cssFile('@web/plugins/datetimepicker/bootstrap-datetimepicker.min.css')?>




            <!--        --><?php //$this->registerJsFile("@web/js/layer.js");?>
            <?=Html::cssFile('@web/css/jquery-confirm.css')?>
            <?=Html::jsFile('@web/js/jquery-confirm.min.js')?>
            <?=Html::jsFile('@web/js/layer.js')?>
            <?=Html::jsFile('@web/js/main.js')?>
            <script src="https://cdn.bootcss.com/bluebird/3.5.1/bluebird.core.js"></script>
            <style>
                #browser_pop {position:absolute;width:100%;height:100%;left:0;top:0;background:#000;opacity:0.9;z-index:99999;display:none;}
                #browser_pop h2 {text-align:center;padding:50px 0;color:#fff;font-size:20px;}
                #browser_pop h2 a {color:red;}
            </style>
            <script>

                var Promise = window.Promise;
            </script>
        </head>
        <style>
            .fa-20x{font-family: 'Microsoft YaHei';font-size: 20px;line-height: 2em;}
            .fa-10x{font-family: 'Microsoft YaHei';font-size: 18px;line-height: 1em;}
            div.dataTables_wrapper select{width: auto;margin: 0 4px;}
            .navbar-brand .logo{max-height: 30px;border-radius: 3px;}
            table td{word-wrap: break-word;}
            .flleft{float: left;padding-left: 10%;}
        </style>
        <body  style="font-size: 12px;">
            <div id="browser_pop">
                <h2>本系统不支持IE浏览器，请使用其他浏览器查看，或<a href="http://rj.baidu.com/soft/detail/14744.html">下载chrome浏览器。</a></h2>
            </div>



            <?php $this->beginBody() ?>

            <section class="vbox">
                <script>
                    function browserType(){
                        if (window.navigator.userAgent.indexOf("MSIE")>=1)  {
                            $('#browser_pop').show();
                        }else if (!!window.ActiveXObject || "ActiveXObject" in window){
                            $('#browser_pop').show();
                        }

                    }
                    browserType();
                </script>
                <section id="administration">
                    <section class="hbox stretch">
                        <!-- 公用左侧导航  begin-->
                        <div class="left_bar">
                            <div class="logo">
                                <p>
                                    <a href="/site/index">
                                        <img src="<?=Url::to('@web/images/logo.png');?>">
                                    </a>
                                </p>
                            </div>
                            <p class="administration_name"><?php echo \Yii::$app->user->identity->username;?></p>
                            <div class="system_management">
                                <p>
                                    <i></i>
                                    酒店管理
                                    <b></b>
                                </p>
                                <ul>
                                    <li>
                                        <a href="<?=Url::to(['hotel/index']);?>">
                                            <span>酒店管理</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="data_center">
                                <p>
                                    <i></i>
                                    数据中心
                                    <b></b>
                                </p>
                                <ul>
                                    <li>
                                        <a href="<?=Url::to(['order/index']);?>">
                                            <span>订单数据</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- 公用左侧导航  end-->
                        <div class="manage_content">
                            
                            <div class="data_container">
                                <?= $content ?>
                            </div>
                        </div>
                    </section>
                </section>
            </section>

        </body>
        <script>
            $('.system_management p').click(function(){
                $(this).siblings('ul').slideToggle()
            })

            $('.data_center p').click(function(){
                $(this).siblings('ul').slideToggle()
            })

            $('.search').on('click','p',function(){
                $(this).siblings('ul').slideToggle()
            })

            $('.search').on('click','li',function(){
                $(this).addClass('active').siblings('.active').removeClass('active')
                $('.search_type').val($(this).html())
                $(this).parent().slideUp()
            })

            $(function(){
                var pathName = window.location.pathname
                var lis = $('.system_management li')
                $('.left_bar li').removeClass('hover')
                if(pathName == '/admin/update'){
                    $('.system_management li:first-child').addClass('hover')
                }else if(pathName == '/admin/index'){
                    $('.system_management li:last-child').addClass('hover')
                }else if(pathName == "/users/index"){
                    $('.data_center li:first-child').addClass('hover')
                }
            })
                
        </script>
    </html>
<?php $this->endPage() ?>