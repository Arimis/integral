<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralGift */

$this->title = Yii::t('arimis-integral', 'Create Integral Gift');
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Gifts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-gift-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
