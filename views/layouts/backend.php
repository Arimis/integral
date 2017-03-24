<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/1/18
 * Time: 11:52
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use app\extensions\helpers\Menu;

AdminAsset::register($this);
$this->registerJs('$(\'.navbar-toggle\').click(function() {
      return $(\'body, html\').toggleClass("nav-open");
    });');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="modal-shiftfix">
    <div class="navbar navbar-fixed-top scroll-hide">
        <div class="container-fluid top-bar">
            <div class="pull-right">
                <ul class="nav navbar-nav pull-right">
                    <?php if(Yii::$app->user->isGuest):?>
                    <li class="user hidden-xs">
                        <a href="/admin/index/login">
                            <img width="34" height="34" src="images/avatar-male.jpg"/><?=Yii::t("app", "Login")?><b class="caret"></b>
                        </a>
                    </li>
                    <?php else: ?>
                    <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img width="34" height="34" src="images/avatar-male.jpg"/><?= Yii::$app->user->identity->account?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">
                                    <i class="icon-user"></i><?= Yii::t('app', 'My Account')?></a>
                            </li>
                            <li><a href="#">
                                    <i class="icon-gear"></i><?= Yii::t('app', 'My Profile')?></a>
                            </li>
                            <li><a href="/admin/index/logout">
                                    <i class="icon-signout"></i><?= Yii::t('app', 'Logout')?></a>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span
                        class="icon-bar"></span></button>
            <a class="logo" href="/admin/index">Leibish</a>
            <!--<form class="navbar-form form-inline col-lg-2 hidden-xs">
                <input class="form-control" placeholder="Search" type="text">
            </form>-->
        </div>
        <div class="container-fluid main-nav clearfix">
            <div class="nav-collapse">
                <ul class="nav">
                    <li>
                        <a <?php if (Menu::isActive(['/admin/index/index'])): echo 'class="current"';endif; ?>
                                href="/admin/index/index"><span aria-hidden="true" class="se7en-home"></span><?=Yii::t('app', 'Dashboard') ?></a>
                    </li>
                    <li><a <?php if (Menu::isActive(['/admin/dia/index', '/admin/dia/view', '/admin/dia/create', '/admin/dia/update'])): echo 'class="current"';endif; ?>
                                href="/admin/dia/index">
                            <span aria-hidden="true" class="se7en-feed"></span><?=Yii::t('app', 'Colored Diamond Management') ?></a>
                    </li>
                    <li><a <?php if (Menu::isActive(['/admin/user/index', '/admin/user/view', '/admin/user/create', '/admin/user/update'])): echo 'class="current"';endif; ?>
                        href="/admin/user/index">
                            <span aria-hidden="true" class="se7en-charts"></span><?=Yii::t('app', 'Customer Management') ?></a>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown" href="#" <?php if (Menu::isActive([
                            '/admin/coupon/index', '/admin/coupon/view', '/admin/coupon/create', '/admin/coupon/update',
                            '/admin/share/index', '/admin/share/view', '/admin/share/create', '/admin/share/update',
                        ])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-star"></span><?= Yii::t('app', 'Promotion Management')?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a <?php if (Menu::isActive(['/admin/share/index', '/admin/share/view', '/admin/share/create', '/admin/share/update'])): echo 'class="current"';endif; ?>
                                        href="/admin/share/index    "><?= Yii::t('app', 'Share Links Management')?></a>
                            </li>
                            <li>
                                <a <?php if (Menu::isActive(['/admin/coupon/index', '/admin/coupon/view', '/admin/coupon/create', '/admin/coupon/update'])): echo 'class="current"';endif; ?>
                                        href="/admin/coupon/index"><?= Yii::t('app', 'Coupons Management')?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown" href="#" <?php if (Menu::isActive([
                            '/admin/gift/index', '/admin/gift/view', '/admin/gift/create', '/admin/gift/update',
                            '/admin/order/index', '/admin/order/view', '/admin/order/create', '/admin/order/update',
                        ])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-star"></span><?= Yii::t('app', 'Integral Shopping')?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a <?php if (Menu::isActive(['/admin/order/index', '/admin/order/view', '/admin/order/create', '/admin/order/update'])): echo 'class="current"';endif; ?>
                                        href="/admin/order/index    "><?= Yii::t('app', 'Orders Management')?></a>
                            </li>
                            <li>
                                <a <?php if (Menu::isActive(['/admin/gift/index', '/admin/gift/view', '/admin/gift/create', '/admin/gift/update'])): echo 'class="current"';endif; ?>
                                        href="/admin/gift/index"><?= Yii::t('app', 'Point Gifts Management')?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown" href="#" <?php if (Menu::isActive([
                            '/admin/account/index', '/admin/account/view', '/admin/account/create', '/admin/account/update',
                            '/admin/auth-item/index', '/admin/auth-item/view', '/admin/auth-item/create', '/admin/auth-item/update',
                            '/admin/assign/index', '/admin/assign/view', '/admin/assign/create', '/admin/assign/update',
                        ])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-pages"></span><?=Yii::t("app", "Authoritarian Management")?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/admin/account/index" <?php if (Menu::isActive(['/admin/account/index', '/admin/account/view', '/admin/account/create', '/admin/account/update'])): echo 'class="current"';endif; ?>><?=Yii::t("app", "Administrators Management")?></a>
                            </li>
                            <li>
                                <a href="/admin/auth-item/index" <?php if (Menu::isActive(['/admin/auth-item/index', '/admin/auth-item/view', '/admin/auth-item/create', '/admin/auth-item/update'])): echo 'class="current"';endif; ?>><?=Yii::t("app", "Roles Management");?></a>
                            </li>
                            <!--<li>
                                <a href="<?/*=\yii\helpers\Url::toRoute("/admin/auth-item-child")*/?>"><?/*=Yii::t("app", "角色子集");*/?></a>
                            </li>
                            <li>
                                <a href="<?/*=\yii\helpers\Url::toRoute("/admin/auth-rule")*/?>"><?/*=Yii::t("app", "权限规则");*/?></a>
                            </li>-->
                            <li>
                                <a href="/admin/assign/index" <?php if (Menu::isActive(['/admin/assign/index', '/admin/assign/view', '/admin/assign/create', '/admin/assign/update'])): echo 'class="current"';endif; ?>><?=Yii::t("app", "Assignments Management");?></a>
                            </li>
                        </ul>
                    </li>
                    <!--<li><a href="gallery.html">
                            <span aria-hidden="true" class="se7en-gallery"></span>Gallery</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid main-content">
<!--        <div class="page-title">-->
            <h1>
                <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => Yii::t('app', 'Dashboard'), 'url' => ['/admin/index/index']],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </h1>
<!--        </div>-->
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::t('app', 'Powered By {Tech Support Team}', [
                'Tech Support Team' => Yii::t('app', 'Tech Support Team'),
            ]) ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
