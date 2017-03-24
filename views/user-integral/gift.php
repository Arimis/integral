<?php


/* @var $this yii\web\View */
/* @var $userBase \arimis\integral\IntegralUserInterface */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Shares');
$this->params['breadcrumbs'][] = $this->title;

//$this->registerCssFile('@web/css/front/integral.css');
\arimis\integral\assets\IntegralAsset::register($this);

$inPageJs = <<<EOF
    var height=$(window).height();
    var box_height=parseInt(height - 45);
    $(".main-content").css({'min-height':box_height});
    
    var userAvailablePoints = {$userBase->getAvailable()};
    
    $(document).delegate(".int_container li","click",function(){
        var sel=$(this).find("i");
        var giftCode = $(this).attr('data-gift-code');
        var giftPoint = $(this).attr('data-gift-point');
        if(sel.hasClass('icon-ok-sign')){
            sel.removeClass('icon-ok-sign');
            setExchangeUrl(giftCode, 'remove');
        }else{
            if(setExchangeUrl('add', giftCode, giftPoint)) {
                sel.addClass("icon-ok-sign");
            }
        }
        
        var lis=$(".int_container li").find(".icon-ok-sign").length;
        $(".int_Selected em").html(lis);
    });
    
    $('.navbar-toggle').click(function() {
        if($('body, html').hasClass("nav-open")){
            $(".int_Selected").show();
        }else{
            $(".int_Selected").hide();
        }
    });
    
    function setExchangeUrl(type, giftCode, point) {
        if(!giftCode) {
            return false;
        }
        if(!point) {
            point = 0;
        }
    
        var oldCodes = $('#exchangeBtn').attr('data-codes');
        var pickedPoints = $('#exchangeBtn').attr('data-points');
        var codeArr = [];
        if(oldCodes && oldCodes.length > 0) {
            codeArr = oldCodes.split(",");
        }
        if(!pickedPoints) {
            pickedPoints = 0;
        }
        if(type == 'add') {
            if($.inArray(giftCode, codeArr) < 0) {
                if((pickedPoints + point) > userAvailablePoints) {
                    alert("对不起，可用积分不足！");
                    return false;
                }
                codeArr.push(giftCode);
                pickedPoints += point;
            }
        }
        else {
            if($.inArray(giftCode, codeArr) >= 0) {
                var codeArrTmp = []; 
                for(index in codeArr) {
                    if(codeArr[index] != giftCode) {
                        codeArrTmp.push(giftCode);
                    }
                }
                codeArr = codeArrTmp;
                delete codeArrTmp;
                pickedPoints -= point;
            }
        }
        var codeStr = codeArr.join(",");
        $('#exchangeBtn').attr('data-codes', codeStr);
        $('#exchangeBtn').attr('data-points', pickedPoints);
        return true;
    }
    
    $('#exchangeBtn').click(function() {
        var codes = $(this).attr('data-codes');
        var url = $(this).attr('href');
        $(this).attr('href', url + '?' + 'gift_codes=' + codes);
        return true;
    });
EOF;
$this->registerJs($inPageJs);

?>
<!---积分兑换列表--->
<div class="main-content main" style="background: #fff0ed;">
    <div class="int_Selected">选择(<em>0</em>)</div>
    <div class="int_nav">
        <span class="left">可用积分：<em><?=$userBase->getAvailable()?></em></span>
        <label class="share"><a href="<?=\yii\helpers\Url::toRoute("/front/share/index") ?>"><i class="icon-share-alt"></i><br>分享赢积分</a></label>
    </div>
    <div class="int_container">
        <ul>
            <?php if(isset($data)): ?>
            <?php foreach ($data as $datum):?>
            <?php /**
                     * @var \arimis\integral\models\IntegralGift $datum
                     */
                    ?>
            <li data-gift-code="<?=$datum->gift_code?>" data-gift-point="<?=$datum->gift_points?>">
                <div>
                    <img src="<?=$datum->gift_list_pic;?>" alt=""/>
                    <span class="int_con"><?=$datum->gift_points?>积分</span>
                </div>
                <a href="<?=\yii\helpers\Url::to(["/integral/user-integral/view", 'gift_code' => $datum->gift_code]) ?>"><?=$datum->gift_name?></a>
                <i></i>
            </li>
            <?php endforeach;?>
            <?php endif;?>
        </ul>
    </div>
    <a class="int_button" href="<?=\yii\helpers\Url::toRoute("/integral/user-integral/exchange")?>" id="exchangeBtn">立即兑换</a>
</div>
