<?php
/**
 * Created by Arimis Wang using eclipse neon on 2017年3月13日14:16:43
 * @author Arimis Wang
 * @package interpreter
 * @license 上海珂兰商贸有限公司
 * @link wangwengang@kela.cn
 */

namespace arimis\integral\assets;

use yii\web\AssetBundle;

class IntegralAsset extends AssetBundle {

    /**
     * {@inheritdoc}
     */
    public $js = [
        'js/idangerous.swiper.min.js'
    ];

    /**
     * {@inheritdoc}
     */
    public $css = [
        'css/gift.css?2',
        'css/integral.css?2',
        'css/idangerous.swiper.css'
    ];

    /**
     * {@inheritdoc}
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    }
}