<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralRule */

$this->title = $model->rule_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-rule-view">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Update'), ['update', 'id' => $model->rule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('arimis-integral', 'Delete'), ['delete', 'id' => $model->rule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('arimis-integral', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'rule_id',
            'rule_name',
            'rule_desc:ntext',
            'target_class_name',
            'is_active',
            'scope',
            'is_dynamic_point',
            'condition_column',
            'condition_type',
            'condition_value_range',
            'group',
            'weight',
            'stackable',
            'change_points',
            'change_type',
            'is_dynamic_point',
            'invoke_status_column',
            'invoke_status_value_before',
            'invoke_status_value_target',
            'change_frequency_type',
            'change_frequency_value',
            'time_start',
            'time_end',
            'create_time',
            'modify_time',
            'create_admin',
        ],
    ]) ?>

</div>
