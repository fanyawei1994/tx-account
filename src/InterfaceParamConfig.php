<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 11:43
 */

namespace Tesoon\Account;

/**
 * 配置参数获取接口
 * @package Tesoon\Account
 */
interface InterfaceParamConfig
{
    /**
     * 获取配置值
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getValue(string $key, $default = null);
}
