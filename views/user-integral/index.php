<?php
use yii\web\View;
use yii\helpers\Url;
use arimis\integral\IntegralUserInterface;
use arimis\integral\rule\RuleInterface;

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/1/20
 * Time: 18:14
 */

/**
 *
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
<style>
    .summary{padding:0 0 15px 10px ;}
    .table > thead > tr > th, .table > tbody > tr > td{  border-bottom: 1px solid #dddddd; text-align: center; padding:4px 0; font-weight: normal; }

</style>
<div>
    <!-- 个人中心--->
    <div class="main-content main" style="background: #fff; color: #666; position: relative;">
        <div class="user_list">
            <ul>
                <li class="show_int"><span><em><?=$userBase->getTotal()?></em><br>总积分</span> <span><em><?=$userBase->getAvailable()?></em><br>可用积分</span> <span><em><?=$userBase->getFrozen()?></em><br>冻结积分</span> <span style="border-left: 1px solid #efefef;"> <a
                        href="<?=Url::toRoute("/front/share/index");?>" class="" style="color: #f6827a;"><i class="icon-share-alt"></i><br>分享赢积分</a>
                </span></li>
            </ul>

        <?=\yii\grid\GridView::widget([
            'dataProvider' => $dataProvider, 
            /* 'filterModel' => $searchModel, */
            'columns' => [
                ['attribute' => 'create_time', 'label' => Yii::t("arimis-integral", "时间"), "value" => function($model) {
                    return date("Y-m-d H:i", strtotime($model->create_time));
                }],
                ['attribute' => 'change_type', 'label' => Yii::t("arimis-integral", "方式"), 'value' => function($model) {
                    switch ($model->change_type) {
                        case RuleInterface::INTEGRAL_CHANGE_TYPE_INCREASE: {
                            return Yii::t("arimis-integral", "增加");
                            break;
                        }
                        case RuleInterface::INTEGRAL_CHANGE_TYPE_REDUCE: {
                            return Yii::t("arimis-integral", "减少");
                            break;
                        }
                        case RuleInterface::INTEGRAL_CHANGE_TYPE_FROZE: {
                            return Yii::t("arimis-integral", "冻结");
                            break;
                        }
                        case RuleInterface::INTEGRAL_CHANGE_TYPE_THAW: {
                            return Yii::t("arimis-integral", "解冻");
                            break;
                        }
                    }
                }], 
                ['attribute' => 'change_points', 'label' => Yii::t("arimis-integral", "数量")],
                ['attribute' => 'before_available', 'label' => Yii::t("arimis-integral", "可用（前）")],
                ['attribute' => 'after_available', 'label' => Yii::t("arimis-integral", "可用（后）")],
                ['attribute' => 'before_frozen', 'label' => Yii::t("arimis-integral", "冻结（前）")],
                ['attribute' => 'after_frozen', 'label' => Yii::t("arimis-integral", "冻结（后）")],
            ]]);?>

    </div>
    </div>
    <!-- 个人中心--->

</div>
<!---公用中间内容区域--->


