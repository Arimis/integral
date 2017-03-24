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
use app\assets\AdminAsset;

AdminAsset::register($this);
/**
 *  手机访问时左侧按钮弹出
 */
$inPageJs = <<<EOF
    jQuery(document).ready(function () {
        $('.navbar-toggle').click(function() {
            return $('body, html').toggleClass("nav-open");
        });
    });
EOF;

$this->registerJs($inPageJs);

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
            <!--<div class="pull-right">
                <ul class="nav navbar-nav pull-right">
                    <?php /*if(Yii::$app->user->isGuest):*/ ?>
                    <li class="user hidden-xs">
                        <a href="/front/index/index">
                            <img width="34" height="34" src="/seven/images/avatar-male.jpg"/><? /*=Yii::t("app", "Login")*/ ?><b class="caret"></b>
                        </a>
                    </li>
                    <?php /*else: */ ?>
                    <li class="dropdown user hidden-xs"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img width="34" height="34" src="images/avatar-male.jpg"/><? /*= Yii::$app->user->identity->account*/ ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">
                                    <i class="icon-user"></i><? /*= Yii::t('app', 'My Account')*/ ?></a>
                            </li>
                            <li><a href="#">
                                    <i class="icon-gear"></i><? /*= Yii::t('app', 'My Profile')*/ ?></a>
                            </li>
                            <li><a href="/front/index/logout">
                                    <i class="icon-signout"></i><? /*= Yii::t('app', 'Logout')*/ ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php /*endif; */ ?>
                </ul>
            </div>-->
            <button class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span
                        class="icon-bar"></span></button>
            <a class="logo" href="/front/index">Leibish</a>
            <!--<form class="navbar-form form-inline col-lg-2 hidden-xs">
                <input class="form-control" placeholder="Search" type="text">
            </form>-->
        </div>
        <div class="container-fluid main-nav clearfix">
            <div class="nav-collapse">
                <ul class="nav">
                    <li>
                        <a <?php if (\app\extensions\helpers\Menu::isActive(['/front/user/index'])): echo 'class="current"';endif; ?>
                                href="/front/user/index"><span aria-hidden="true"
                                                                class="se7en-home"></span><?= Yii::t('app', 'Home') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/front/dia" <?php if (\app\extensions\helpers\Menu::isActive(['/front/dia'])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-feed"></span><?= Yii::t('app', 'Dia Search') ?></a>
                    </li>
                    <li>
                        <a href="/front/point-gift" <?php if (\app\extensions\helpers\Menu::isActive(['/front/point-gift'])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-charts"></span><?= Yii::t('app', 'Point Gifts') ?></a>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown"
                                            href="#" <?php if (\app\extensions\helpers\Menu::isActive(['/front/share/index', '/front/coupon/index', '/front/coupon/mine'])): echo 'class="current"';endif; ?>>
                            <span aria-hidden="true" class="se7en-star"></span><?= Yii::t('app', 'Promotion') ?><b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/front/share/index" <?php if (\app\extensions\helpers\Menu::isActive(['/front/share/index'])): echo 'class="current"';endif; ?>><?= Yii::t('app', 'Share Links') ?></a>
                            </li>
                            <li>
                                <a href="/front/coupon/index" <?php if (\app\extensions\helpers\Menu::isActive(['/front/coupon/index'])): echo 'class="current"';endif; ?>><?= Yii::t('app', 'Get Coupons') ?></a>
                            </li>
                            <li>
                                <a href="/front/coupon/mine" <?php if (\app\extensions\helpers\Menu::isActive(['/front/coupon/mine'])): echo 'class="current"';endif; ?>><?= Yii::t('app', 'My Coupon') ?></a>
                            </li>
                        </ul>
                    </li>
                    <!--<li class="dropdown"><a data-toggle="dropdown" href="#">
                            <span aria-hidden="true" class="se7en-forms"></span>Forms<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="form-components.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Form Components
                                    </p></a>

                            </li>
                            <li>
                                <a href="form-advanced.html">Advanced Forms</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown" href="#">
                            <span aria-hidden="true" class="se7en-tables"></span>Tables<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="tables.html">Basic tables</a>
                            </li>
                            <li>
                                <a href="datatables.html">DataTables</a>
                            </li>
                            <li><a href="datatables-editable.html">
                                    <div class="notifications label label-warning">
                                        New
                                    </div>
                                    <p>
                                        Editable DataTables
                                    </p></a>

                            </li>
                        </ul>
                    </li>
                    <li><a href="charts.html">
                            <span aria-hidden="true" class="se7en-charts"></span>Charts</a>
                    </li>
                    <li class="dropdown"><a data-toggle="dropdown" href="#">
                            <span aria-hidden="true" class="se7en-pages"></span>Pages<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="chat.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Chat
                                    </p></a>

                            </li>
                            <li>
                                <a href="calendar.html">Calendar</a>
                            </li>
                            <li><a href="timeline.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Timeline
                                    </p></a>

                            </li>
                            <li><a href="login1.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Login 1
                                    </p></a>

                            </li>
                            <li>
                                <a href="login2.html">Login 2</a>
                            </li>
                            <li><a href="signup1.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Sign Up 1
                                    </p></a>

                            </li>
                            <li>
                                <a href="signup2.html">Sign Up 2</a>
                            </li>
                            <li><a href="invoice.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        Invoice
                                    </p></a>

                            </li>
                            <li><a href="faq.html">
                                    <span class="notifications label label-warning">New</span>
                                    <p>
                                        FAQ
                                    </p></a>

                            </li>
                            <li>
                                <a href="filters.html">Filter Results</a>
                            </li>
                            <li>
                                <a href="404-page.html">404 Page</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="gallery.html">
                            <span aria-hidden="true" class="se7en-gallery"></span>Gallery</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid main-content">
        <?= $content ?>
    </div>
</div>
<?php if(isset($hideCopyRight) && $hideCopyRight):?>
<footer class="footer">
    <div class="row">
        <div class="container col-lg-12">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

            <p class="pull-right"><?= Yii::t('app', 'Powered By {Tech Support Team}', [
                'Tech Support Team' => Yii::t('app', 'Tech Support Team'),
            ]) ?></p>
        </div>
    </div>
</footer>
<?php endif;?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
