<?php
/**
 * Created by IntelliJ IDEA.
 * User: arimis
 * Date: 17-2-9
 * Time: 下午5:17
 */

namespace arimis\integral;


use yii\base\Model;
use yii\db\ActiveRecord;
use yii\base\Component;

class UniqueCodeService extends Component
{
    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @var int
     */
    public $maxUniqueCode;

    /**
     * @var string
     */
    public $prefix = '';

    /**
     * @var string
     */
    public $delimiter = '-';

    /**
     * @var string
     */
    public $columnName = '';

    /**
     * @return ActiveRecord
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param ActiveRecord $model
     * @return UniqueCodeService
     */
    public function setModel(ActiveRecord $model)
    {
        if(!$model instanceof ActiveRecord) {
            throw new \InvalidArgumentException(\Yii::t('app', "The first argument should be an instance of \\yii\\db\\ActiveRecord"));
        }
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxUniqueCode()
    {
        if(empty($this->maxUniqueCode)) {
            $todayMark = $this->getPrefix() . $this->getDelimiter() . date("Ymd") . $this->getDelimiter();
            $maxCodeColumnValue = \Yii::$app->getDb()->createCommand("SELECT {$this->getColumnName()} AS maxCode FROM {$this->model->tableName()} WHERE {$this->getColumnName()} LIKE '{$todayMark}%' ORDER BY {$this->getColumnName()} DESC LIMIT 1")->queryColumn();
            if(empty($maxCodeColumnValue)) {
                $maxUniqueCode = 0;
            }
            else {
                $maxCodeColumnValue = explode($this->getDelimiter(), array_shift($maxCodeColumnValue));
                $maxUniqueCode = intval(array_pop($maxCodeColumnValue));
            }
            $this->maxUniqueCode = $maxUniqueCode;
        }
        return $this->maxUniqueCode;
    }

    /**
     * @param int $maxUniqueCode
     * @return UniqueCodeService
     */
    public function setMaxUniqueCode($maxUniqueCode)
    {
        $this->maxUniqueCode = $maxUniqueCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        if(empty($this->prefix)) {
            $this->prefix = "KL";
            if(!empty($this->getModel())) {
                $defaultPrefix = "";
                array_map(function($val) use (&$defaultPrefix) {
                    $defaultPrefix .= $val{0}; 
                }, explode("_", $this->model->tableName()));
                    $this->prefix = strtoupper($defaultPrefix);
            }
        }
        return $this->prefix;
    }

    /**
     * @param string $prefix
     * @return UniqueCodeService 
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getDelimiter()
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     * @return UniqueCodeService
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    /**
     * @return string
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * @param string $columnName
     * @return UniqueCodeService
     */
    public function setColumnName($columnName)
    {
        $this->columnName = $columnName;
        return $this;
    }

    /**
     * UniqueCodeService constructor.
     * @param $model ActiveRecord
     * @param $column string
     */
    public function __construct(ActiveRecord $model, $column)
    {
        $this->setModel($model);
        $this->setColumnName($column);
    }

    /**
     * 返回最新可用的编码，并且给对应的model的对应字段赋值
     * @return string
     */
    public function getCurrentCode() {
        $maxCode = intval($this->getMaxUniqueCode()) + 1;
        //不足5位左侧补0
        if(strlen($maxCode) < 5) {
            $leftLength = 5 - strlen($maxCode);
            $preZeros = '';
            for($i = 1;$i< 5; $i++) {
                $preZeros .= '0';
            }
            $maxCode = $preZeros . $maxCode;
        }
        $currentCode = $this->getPrefix() . $this->getDelimiter() . date('Ymd') . $this->getDelimiter() . $maxCode;
        $this->model->{$this->columnName} = $currentCode;
        return $currentCode;
    }
    
    /**
     * 检查是否存在某个编码
     * @param string $code
     * @return \yii\db\ActiveRecord
     */
    public function checkExists($code) {
        return $this->model->findOne([$this->columnName => $code]);
    }
}