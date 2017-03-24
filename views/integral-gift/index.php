<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('arimis-integral', 'Integral Gifts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integral-gift-index">

    <p>
        <?= Html::a(Yii::t('arimis-integral', 'Create Integral Gift'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'gift_id',
            ['attribute' => 'gift_list_pic', 'format' => ['image', ['width' => '80', 'height' => '80']]],
            'gift_code',
            'gift_name',
            'gift_points',
            // 'gift_quantity',
             'gift_cost',
             'gift_purchase_price',
//             'gift_desc:ntext',
             'is_onsale',
            // 'sort',
             'create_time',
            // 'modify_time',
            // 'create_admin',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
