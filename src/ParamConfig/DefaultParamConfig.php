<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 14:37
 */

namespace Tesoon\Account\ParamConfig;

use Tesoon\Account\InterfaceParamConfig;

/**
 * 不使用框架的参数获取
 */
class DefaultParamConfig implements InterfaceParamConfig
{
    /**
     * @var array 配置数据
     */
    public $configs = [];

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getValue(string $key, $default = null)
    {
        return self::getValueByKey($this->configs, $key, $default);
    }

    /**
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function getValueByKey($array, $key, $default = null)
    {
        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValueByKey($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }
        if (!is_array($array) || !(isset($array[$key]) || array_key_exists($key, $array))) {
            return $default;
        }
        return $array[$key];
    }
}
