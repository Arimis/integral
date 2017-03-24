<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralRule */

$this->title = Yii::t('arimis-integral', 'Update Integral Rule:' . $param['model']->rule_code);
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-rule-create">

    <?= $this->render('_form', $param) ?>

</div>
