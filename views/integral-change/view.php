<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model arimis\integral\models\IntegralChange */

$this->title = $model->log_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('arimis-integral', 'Integral Changes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-change-view">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Update'), ['update', 'id' => $model->log_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('arimis-integral', 'Delete'), ['delete', 'id' => $model->log_id], [
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
            'log_id',
            'user_code',
            'rule_id',
            'rule_name',
            'change_type',
            'change_points',
            'before_available',
            'after_available',
            'before_frozen',
            'after_frozen',
            'params',
            'create_time',
            'modify_time',
            'create_admin',
        ],
    ]) ?>

</div>
