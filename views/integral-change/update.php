<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralChange */

$this->title = Yii::t('arimis-integral', 'Update {modelClass}: ', [
    'modelClass' => 'Integral Change',
]) . $model->log_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Changes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->log_id, 'url' => ['view', 'id' => $model->log_id]];
$this->params['breadcrumbs'][] = Yii::t('arimis-integral', 'Update');
?>
<div class="integral-change-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
