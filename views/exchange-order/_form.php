<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\ExchangeOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exchange-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_sn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_points_amount')->textInput() ?>

    <?= $form->field($model, 'order_cash_amount')->textInput() ?>

    <?= $form->field($model, 'item_quantity')->textInput() ?>

    <?= $form->field($model, 'user_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_type')->textInput() ?>

    <?= $form->field($model, 'delivery_fee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'consignee')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direct_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'order_status')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('arimis-integral', 'Create') : Yii::t('arimis-integral', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
