<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model arimis\integral\models\ExchangeOrder */

$this->title = Yii::t('arimis-integral', 'Create Exchange Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Exchange Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-order-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
