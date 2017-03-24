<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralRuleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="integral-rule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rule_id') ?>

    <?= $form->field($model, 'rule_name') ?>

    <?= $form->field($model, 'rule_desc') ?>

    <?= $form->field($model, 'target_class_name') ?>

    <?= $form->field($model, 'is_active') ?>

    <?php // echo $form->field($model, 'scope') ?>

    <?php // echo $form->field($model, 'is_dynamic_point') ?>

    <?php // echo $form->field($model, 'condition_column') ?>

    <?php // echo $form->field($model, 'condition_type') ?>

    <?php // echo $form->field($model, 'condition_value_range') ?>

    <?php // echo $form->field($model, 'group') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'stackable') ?>

    <?php // echo $form->field($model, 'change_points') ?>

    <?php // echo $form->field($model, 'change_type') ?>

    <?php // echo $form->field($model, 'invoke_status_column') ?>

    <?php // echo $form->field($model, 'invoke_data_storage_status') ?>

    <?php // echo $form->field($model, 'invoke_status_value_before') ?>

    <?php // echo $form->field($model, 'invoke_status_value_target') ?>

    <?php // echo $form->field($model, 'change_frequency') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'modify_time') ?>

    <?php // echo $form->field($model, 'create_admin') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('arimis-integral', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('arimis-integral', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
