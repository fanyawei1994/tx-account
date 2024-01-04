<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 14:38
 */

namespace Tesoon\Account\ParamConfig;

use Tesoon\Account\InterfaceParamConfig;
use Yii;

/**
 * Yii2配置参数
 */
class Yii2ParamConfig implements InterfaceParamConfig
{
    /**
     * 获取配置值
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $key, $default = null)
    {
        $value = ArrayHelper::getValue(Yii::$app->params, '_txAccountConfig.'.$key, $default);
        if (empty($value)) {
            throw new InvalidConfigException('请在param中设置【_txAccountConfig.'.$key.'】');
        }
        return $value;
    }
}
