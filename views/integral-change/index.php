<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('arimis-integral', 'Integral Changes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-change-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'log_id',
            'user_code',
            'change_desc',
            'change_type',
             'change_points',
             'before_available',
             'after_available',
             'before_frozen',
             'after_frozen',
             'params',
             'create_time',
             'modify_time',
            // 'create_admin',

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
