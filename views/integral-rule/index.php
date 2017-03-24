<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel arimis\integral\models\IntegralRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('arimis-integral', 'Integral Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-rule-index">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Create Integral Rule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'rule_id',
            'rule_name',
            'rule_desc:ntext',
            'target_class_name',
            'is_active',
            // 'scope',
             'is_dynamic_point',
            // 'condition_column',
            // 'condition_type',
            // 'condition_value_range',
            // 'group',
            // 'weight',
             'stackable',
            // 'change_points',
            // 'change_type',
            // 'invoke_status_column',
            // 'invoke_status_value_before',
            // 'invoke_status_value_target',
            'change_frequency_type',
            'change_frequency_value',
             'create_time',
            // 'modify_time',
            // 'create_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
