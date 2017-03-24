<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('arimis-integral', 'Exchange Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exchange-order-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'order_id',
            'order_sn',
            'order_points_amount',
            'order_cash_amount',
            'item_quantity',
             'create_time',
            // 'modify_time',
             'user_code',
             'delivery_type',
             'delivery_fee',
             'consignee',
             'province_name',
             'city_name',
             'direct_name',
             'detail_address',
             'order_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
