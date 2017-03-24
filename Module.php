<?php

namespace arimis\integral;

use Yii;
use yii\base\BootstrapInterface;

/**
 * Description of Module
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    public $userClassName;
    public $layoutPath = "@view/layouts";
    public $layout = 'main';

    public $backendLayoutPath = "";
    public $backendLayout = "";
    public $frontendLayoutPath = "";
    public $frontendLayout = "";

    public $controllerNamespace = 'arimis\integral\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Integral::initI18nConfig();
    }

    /**
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        $urlManager = $app->getUrlManager();
        $urlManager->enablePrettyUrl = true;
        $id = $this->uniqueId;
        /*$urlManager->addRules([
            $id => $id . '/integral-rule/index',
            // assignment
            'GET ' . $id . '/integral-rule' => $id . '/integral-rule/index',
            'GET ' . $id . '/integral-rule/<id>' => $id . '/integral-rule/view',
            'POST ' . $id . '/integral-rule/assign/<id>' => $id . '/integral-rule/assign',
            'POST ' . $id . '/integral-rule/revoke/<id>' => $id . '/integral-rule/revoke',
            // item
            'GET ' . $id . '/integral-change' => $id . '/integral-change/index',
            'GET ' . $id . '/integral-change/<id>' => $id . '/integral-change/view',
            'POST ' . $id . '/integral-change/<id>' => $id . '/integral-change/create',
            'POST ' . $id . '/integral-change/update/<id>' => $id . '/integral-change/update',
            'PUT ' . $id . '/integral-change/<id>' => $id . '/integral-change/update',
            'POST ' . $id . '/integral-change' => $id . '/integral-change/create',
            'DELETE ' . $id . '/integral-change/<id>' => $id . '/integral-change/delete',
            // rule
            'GET ' . $id . '/menu' => $id . '/menu/index',
            'GET ' . $id . '/menu/values' => $id . '/menu/values',
            'GET ' . $id . '/menu/<id>' => $id . '/menu/view',
            'POST ' . $id . '/menu/<id>' => $id . '/menu/update',
            'POST ' . $id . '/menu' => $id . '/menu/create',
            'DELETE ' . $id . '/menu/<id>' => $id . '/menu/delete',
            ], false);*/
        $this->viewPath = "@app/services/integral/views";
        if(empty($this->layoutPath))
        {
            $this->layoutPath = $this->viewPath . "/layout";
        }
        if(empty($this->layout))
        {
            $this->layout = "integral";
        }

        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $contentType = 'application/json';
            if (!isset(Yii::$app->getRequest()->parsers[$contentType])) {
                Yii::$app->getRequest()->parsers[$contentType] = 'yii\web\JsonParser';
            }
            return true;
        }
        return false;
    }
}