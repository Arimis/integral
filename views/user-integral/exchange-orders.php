<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/17
 * Time: 17:27
 */
/**
 * @var \arimis\integral\IntegralUserInterface $userBase
 * @var \yii\web\View $this
 * @var \arimis\integral\models\ExchangeOrder[] $orderList
 * @var \arimis\integral\models\ExchangeOrderItem[] $itemList
 * @var \arimis\integral\models\ExchangeOrderItem[] $items
 */
\arimis\integral\assets\IntegralAsset::register($this);
?>
<style>
    body{background:#fff0ed;}
    .container-fluid{padding:0; }
    .container-fluid .order_list{width:100%; margin-top: -15px; overflow: hidden;}
    .container-fluid .order_list .order_list_top{height:34px;padding:0 12px;margin-top: 10px; font-size: 13px; background: #fff; border-bottom:1px solid #dedede; line-height: 34px;}
    .order_list_top .pull-right em{color:#ff8a81;font-style: normal; }
    .container-fluid .order_list_center{background: #fff; position: relative; overflow: hidden;border-bottom:1px solid #dedede;}
    .order_list_center .inter_img{width:80px; height:80px;float: left;}
    .order_list_center .inter_text{position: absolute; color:#888888;line-height: 22px; top:16px; font-size: 12px; left:0; margin-left: 100px;}
    .order_list_center .inter_text em{color:#f6827a;font-style: normal;}
    .order_list_center .order{overflow: hidden;padding:10px; border-bottom:1px solid #edf2f8;}
    .order_list_center .order:last-child{border:none;}
</style>
<div class="container-fluid main">
    <div class="order_list">
<?php if(count($orderList) > 0):?>
    <?php foreach ($orderList as $order):?>
        <div class="order_list_top"><!--<a href="<?/*=\yii\helpers\Url::toRoute("/integral/user-integral/exchange-order-view?order_sn={$order->order_sn}")*/?>">--><?=$order->order_sn;?>
        <span class="pull-right">总金额：<em>￥<?=$order->order_cash_amount;?></em> &nbsp;&nbsp;总积分：<em><?=$order->order_points_amount;?></em></span></div>
        <div class="order_list_center">
        <?php if(isset($itemList[$order->order_sn])):?>
            <?php $items = $itemList[$order->order_sn];?>
            <?php foreach ($items as $item):?>
                <div class="order" >
                    <div class="inter_img"><img src="<?=$item->list_picture;?>" width="80" height="80"></div>
                    <div class="inter_text">编码：<?=$item->item_code;?><br>名称：<?=$item->item_name;?><br>市场价：<em>￥<?=$item->item_price;?></em>&nbsp;&nbsp;&nbsp;&nbsp;积分：<em><?=$item->item_points;?></em></div>
                </div>

            <?php endforeach;?>
        <?php endif;?>
        </div>
    <?php endforeach;?>
<?php endif;?>
    </div>
</div>