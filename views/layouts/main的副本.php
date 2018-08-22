<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\core\Permission;
use yii\helpers\Url;
//use yii;


AppAsset::register($this);
$menu = array(
    'meeting'       =>array('meeting'),
    'sendrfp'       =>array('sendrfp'),
    'rfp'           =>array('rfp'),
    'hotel'         =>array('place'),
    'users'         =>array('users'),
    'subcompany'    =>array('subcompany'),
    'NearTheHotel'  =>array('search'),
	'SearchPlace'   =>array('psearch'),
    'tuanfangOrder' =>array('order'),
    'log'           =>array('action-log'),
    'yrfp'          =>array('yrfp'),
    'site'          =>array('index'),
);
function isActive($menuVal=array(),$returnBool=false){
    $controllerId = strtolower( Yii::$app->controller->id );
    $actionId     = strtolower( Yii::$app->controller->action->id );
    if( isset( $menuVal[$controllerId] ) ){
        if( in_array( $actionId, $menuVal[$controllerId]) ){
            return $returnBool ? true : 'active';
        }
    }else if( in_array( $controllerId, $menuVal) ) {
        return $returnBool ? true : 'active';
    }
    return $returnBool ? false : '';
}
//var_dump(isActive($menu['rfp']));exit;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="https:////cdn.bootcss.com/moment.js/1.0.0/moment.min.js"></script>
</head>
<style type="text/css">
    .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
    html,body{-ms-overflow-style: scrollbar;font-family: "Hiragino Sans GB","Hiragino Sans GB W3","微软雅黑","Microsoft Yahei",Arial,"Times New Roman",Times,serif !important}
    .text-danger{color:#fa2b23!important};
</style>
<body class="skin-blue sidebar-mini">
<?php $this->beginBody() ?>
<style>
    .fixed {
        position: fixed;
        top: 0;
        z-index: 1000;
        height:120px;
        width: 100%;
        -position: absolute;
        -top: expression(eval(document.documentElement.scrollTop))
    }
</style>
<div class="wrap">
    <div class="wrapper">

        <header class="main-header fixed">
            <!-- Logo -->
            <a href="/" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">星球</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="/images/logo.png" alt=""></span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="/users/view?id=<?= Yii::$app->session['__id'] ?>" class="dropdown-toggle">
                                <span class="hidden-xs fa  fa-user">
                                        <?php 
                                            $name = \Yii::$app->user->isGuest ? '' : \Yii::$app->user->identity->username;

                                            $_SESSION['name'] = $name;
                                            echo $name;
                                        ?>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/site/logout">退出</a>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar" style="margin-top: 80px;">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel user-default">
                    <div class="info">
                        <p><?= $name ?></p>
                    </div>
                </div>
<?php

echo \yii\widgets\Menu::widget([
    'options'=>[ 'class'=>'sidebar-menu' ],
    'items' => [

        [
            'label' => '会员管理',
            'url' => [ Url::to('/admin/update?id='.Yii::$app->session['__id']) ],
            //'options'=>['class'=>'treeview'],
            'template'=>'<a href="{url}"><i class="fa fa-fw fa-inbox"></i>&nbsp;&nbsp;<span>{label}</span></a>',
            'active'=>isActive($menu['yrfp'],true),
        ],
        [
            'label' => '合作商管理',
            'url' => [ Url::to('/admin/index') ],
            //'options'=>['class'=>'treeview'],
            'template'=>'<a href="{url}"><i class="fa fa-fw fa-user"></i>&nbsp;&nbsp;<span>{label}</span></a>',
            'active'=>isActive($menu['users'],true),
        ],


        


    ],
]);
?>

            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper" style="margin-top: 100px;">
                                                                            <section class="content-header none">
                                          <?= Breadcrumbs::widget([
                'homeLink'=>false,
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
    </section>
            <section class="content">
                            <?= $content ?>
            </section>
           
        </div>
 <footer class="main-footer">
  </footer>
    </div>
</div>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">

    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->

        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">


        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<?php $this->registerJsFile("/plugins/jQuery/jquery.cookie.js",['depends'=>  \app\assets\AppAsset::className()]) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
