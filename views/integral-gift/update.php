<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralGift */

$this->title = Yii::t('arimis-integral', 'Update {modelClass}: ', [
    'modelClass' => 'Integral Gift',
]) . $model->gift_code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Gifts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gift_code, 'url' => ['view', 'id' => $model->gift_id]];
$this->params['breadcrumbs'][] = Yii::t('arimis-integral', 'Update');
?>
<div class="integral-gift-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
