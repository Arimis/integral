<?php
use arimis\integral\IntegralUserInterface;

/**
 * Created by IntelliJ IDEA.
 * User: Arimis
 * Date: 2017/3/16
 * Time: 10:39
 */

/**
 * @var \arimis\integral\models\IntegralGift $model
 * @var IntegralUserInterface $userBase
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
<div class="main-content cont" style="background: #fff">
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
        <p class="pro_para_title" style="background: #f6f6f6; color: #666;">详情参数</p>
        <p class="inter_text">
            <?=$model->gift_desc?>
        </p>
    </div>
</div>
<!---积分兑换详情-->
<?php if($userBase->getAvailable() > $totalPoints):?>
<a class="int_button" style="background: #c29e6c !important" href="<?=\yii\helpers\Url::toRoute("exchange?gift_codes={$model->gift_code}")?>">
    <span class="pull-left code">（可用积分：<?=$userBase->getAvailable()?>）
    </span>立即兑换</a><?php else:?>
    <a  style="background: #c29e6c !important"  class="int_button" href="javascript:;">
    <span class="pull-left code">（可用积分：<?=$userBase->getAvailable()?>）
    </span>积分不足</a>
<?php endif;?>

