<?php
/* @var $this \yii\web\View */
/* @var $content string */
// use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="viewport" content="width=device-width">
    <link href="/css/base.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
</head>
<body>

<div class="login">
        <div class="logo"></div>
    <div class="login_form">

        <form id="w0" action="/site/login" method="post" role="form">
            <div class="user">
            <input type="hidden" name="_csrf" value="<?= yii::$app->request->getCsrfToken() ?>">
            <?php if ($model->getFirstErrors()): ?>
                <div class="errorBox" id="errorBox">
                    <?php foreach ($model->getFirstErrors() as $error): ?>
                        <?= $error ?>
                        <?php break; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="username">
                <i></i>
                <input type="text" class="text_value" name="LoginForm[username]" placeholder="请输入用户名" value="<?= $model->getIterator()['username'] ?>">
            </div>
            <div class="password">
                <i></i>
                <input type="password" class="text_value" id="loginform-password" name="LoginForm[password]" placeholder="密码" value="<?= $model->getIterator()['password'] ?>">
            </div>
            </div>
<!--            <div class="submitBtn" id="submitBtn">-->
                <button class="button login_sub btn btn-success btn-block" name="login-button" type="submit">登录</button>
<!--            </div>-->
        </form>
        </div>

        <div id="tip"></div>
</div>
<script src="/js/jquery-2.1.1.min.js"></script>
<script src="/js/main.js"></script>
</body>
</html>
