<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralChange */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="integral-change-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rule_id')->textInput() ?>

    <?= $form->field($model, 'rule_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'change_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'change_points')->textInput() ?>

    <?= $form->field($model, 'before_available')->textInput() ?>

    <?= $form->field($model, 'after_available')->textInput() ?>

    <?= $form->field($model, 'before_frozen')->textInput() ?>

    <?= $form->field($model, 'after_frozen')->textInput() ?>

    <?= $form->field($model, 'params')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_admin')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('arimis-integral', 'Create') : Yii::t('arimis-integral', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
