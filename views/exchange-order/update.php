<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\ExchangeOrder */

$this->title = Yii::t('arimis-integral', 'Update {modelClass}: ', [
    'modelClass' => 'Exchange Order',
]) . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Exchange Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_sn, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = Yii::t('arimis-integral', 'Update');
?>
<div class="exchange-order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
