<?php
/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/16
 * Time: 10:39
 */

/**
 * @var \arimis\integral\models\IntegralGift $model
 */
\arimis\integral\assets\IntegralAsset::register($this);

$inPageJs = <<<EOF
    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.pagination',
        loop:true,
        grabCursor: true,
        autoplay:5000,
        paginationClickable: true
    });
EOF;
$this->registerJs($inPageJs);
?>
<!---积分兑换详情-->
<div class="main-content cont">
    <div class="pro_banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/images/z1.jpg" alt=""/></div>
                <div class="swiper-slide"><img src="/images/z2.jpg" alt=""/></div>
                <div class="swiper-slide"><img src="/images/z3.jpg" alt=""/></div>
                <div class="swiper-slide"><img src="/images/z4.jpg" alt=""/></div>
            </div>
        </div>
        <div class="pagination"></div>
    </div>
    <div class="pro_desc">
        <p class="desc1"><?=$model->gift_code?><?=$model->gift_name?></p>
        <p class="price" style="font-size: 13px;">兑换价格：<?=$model->gift_points?>积分 &nbsp;&nbsp;&nbsp;<em style="text-decoration: line-through; color: #999">市场价：￥<?=$model->gift_purchase_price;?></em></p>
    </div>
    <div class="pro_para">
        <p class="pro_para_title">详情参数</p>
        <p class="inter_text">
            <?=$model->gift_desc?>
        </p>
    </div>
</div>
<!---积分兑换详情-->
<a class="int_button" href="<?=\yii\helpers\Url::toRoute("exchange?gift_codes={$model->gift_code}")?>">
    立即兑换
</a>