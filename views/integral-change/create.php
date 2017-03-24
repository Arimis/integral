<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralChange */

$this->title = Yii::t('arimis-integral', 'Create Integral Change');
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Changes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-change-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
