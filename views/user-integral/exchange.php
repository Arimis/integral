<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/16
 * Time: 16:24
 */
use yii\bootstrap\Html;
/**
 * @var \yii\web\View $this
 * @var \arimis\integral\models\IntegralGift[] $gifts
 * @var \arimis\integral\models\IntegralGift $gift
 * @var \arimis\integral\IntegralUserInterface $userBase
 */
$this->title = "确认订单";
\arimis\integral\assets\IntegralAsset::register($this);
$orderUrl = \yii\helpers\Url::toRoute("/integral/user-integral/make-exchange-order");
$inPageJs = <<<EOF
$('#exchangeConfirmBtn').click(function() {
    var giftCodes = $(this).attr('data-gift-codes');
    $.post('{$orderUrl}', {
        giftCodes:  giftCodes   
    }, function(res) {
        if(res.code) {
            if(res.code  == 1 && res.msg) {
                alert("订单已经生成，订单号为：" + res.msg);
                window.location.href = "/integral/user-integral/exchange-orders";
            }
            else {
                alert(res.msg);
            }
        }
        else {
            alert("对不起，请求失败，请联系官方客户处理！");
        }
    }, 'json');
});
EOF;
$this->registerJs($inPageJs);
?>

<style>
    body{background:#fff0ed;}
    .container-fluid{padding:0; }

    .container-fluid .order_list{width:100%; margin-top: -15px; overflow: hidden;}
    .container-fluid .order_list .order_list_top{height:34px;padding:0 12px;font-size: 13px; background: #fff; border-bottom:1px solid #dedede; line-height: 34px;}
    .order_list_top  em{color:#ff8a81;font-style: normal; }
    .container-fluid .order_list_center{background: #fff; position: relative; overflow: hidden;border-bottom:1px solid #dedede;}
    .order_list_center .inter_img{width:80px; height:80px;float: left;}
    .order_list_center .inter_text{position: absolute; color:#888888;line-height: 22px; top:16px; font-size: 12px; left:0; margin-left: 100px;}
    .order_list_center .inter_text em{color:#f6827a;font-style: normal;}
    .order_list_center .order{overflow: hidden;padding:10px; border-bottom:1px solid #edf2f8;}
    .order_list_center .order:last-child{border:none;}
    .container-fluid .no_gift{margin:0 10px; height:40px; line-height: 40px; text-align: center; color:#f6827a;  background: #fff;}
    .int_button:focus,.int_button:link{color: #fff;}
</style>
<div class="container-fluid main">
    <?php if($gifts && count($gifts) > 0):?>
    <div class="order_list">
    <?php foreach ($gifts as $gift):?>
    <div class="order_list_center" style="margin-top: 10px;">
        <div class="order">
            <div class="inter_img">
                <?=Html::img($gift->gift_list_pic, ['width' => '80', 'height' => '80']);?>
            </div>
            <div class="inter_text">
                编号： <?=$gift->gift_code;?><br>
                名称：<?=$gift->gift_name;?><br>
                价格：<em>￥<?=$gift->gift_cost;?></em> &nbsp; &nbsp; &nbsp;  &nbsp;积分：<em><?=$gift->gift_points;?></em>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <div class="order_list_top">
        <div class="pull-left">可用积分：<em>￥<?=$userBase->getAvailable()?></em></div>
        <div class="col-md-6">
            <span class="pull-right">所需积分：<em><?=$totalPoints?></em></span>
        </div>
    </div>

    <?php else:?>
        <div class="no_gift">
           没有选择礼物
        </div>
    <?php endif;?>
    </div>
    <a class="int_button" href="javascript:;" <?php if($userBase->getAvailable() > $totalPoints):?>id="exchangeConfirmBtn"<?php else:?>disabled="disabled"<?php endif;?> data-gift-codes="<?=$giftCodes?>"><?php if($userBase->getAvailable() > $totalPoints):?>确认兑换<?php else:?>积分不足<?php endif;?></a>
</div>

