<?php
use yii\web\View;
use app\models\UserWechat;
use yii\helpers\Url;
use arimis\integral\IntegralUserInterface;

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/1/20
 * Time: 18:14
 */

/**
 * @var View $this
 * @var IntegralUserInterface $userBase
 */
/* @var $searchModel app\models\ShopProdDiaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$inPageJs = <<<EOF
    var width=$(window).width();
    var height=$(window).height();
    var box_height=parseInt(height - 45);
    $(".main-content").css({'min-height':box_height});
    if(width >767){
        $("html").css({'width':'640','margin':'auto'})
    }
    var boxwidth=$(".qr_img").width();
    console.log(boxwidth);
    $(".qr_img").height(boxwidth);
    $(".ewm").on('click',function(){
        $(".qr_code").css({'top':'0'});
    });
   $(".qr_code").on('click',function(){
       $(".qr_code").css({'top':'-100%'});
   });
EOF;
$this->registerJs($inPageJs);
$this->registerCssFile("@web/css/front/user.css");
$this->title = Yii::t("app", "用户首页");
?>

<div>
<!-- 个人中心--->
<div class="main-content main" style="background:#fff0ed; position:relative;">
    <div class="user_list">
        <ul>
            <li class="show_int">
                <span><em><?=$userBase->getTotal()?></em><br>总积分</span>
                <span><em><?=$userBase->getAvailable()?></em><br>可用积分</span>
                <span><em><?=$userBase->getFrozen()?></em><br>冻结积分</span>
                <span style="border-left: 1px solid #efefef;">
                        <a href="<?=Url::toRoute("/front/share/index");?>" class="" style="color: #f6827a;"><i class="icon-share-alt"></i><br>分享赢积分</a>
                    </span>
            </li>
        </ul>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                'create_time',
                'change_type',
                'change_points',
                'before_available',
                'after_available',
                'before_frozen',
                'after_frozen',
            ],
        ]); ?>

    </div>
</div>
<!-- 个人中心--->

</div>
<!---公用中间内容区域--->


