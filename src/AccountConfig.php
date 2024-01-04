<?php
/**
 * User: fanyawei
 * Date: 2023/12/29 14:33
 */

namespace Tesoon\Account;

use InvalidArgumentException;

/**
 * 组件配置
 */
class AccountConfig
{
    /**
     * @var InterfaceParamConfig 配置数据获取
     */
    private static $paramConfig;
    /**
     * @var InterfaceToken 组件内部处理jwt数据的对象
     */
    private static $token;

    /**
     * @var InterfaceRequestSend 组件内容发送接口请求的对象
     */
    private static $sendRequest;

    /**
     * 获取配置值
     * @param string $key
     * @param $default
     * @return mixed
     */
    public static function getParamConfigValue(string $key, $default = null)
    {
        if (empty(self::$paramConfig)) {
            throw new InvalidArgumentException('请先配置【paramGet】值');
        }
        return self::$paramConfig->getValue($key, $default);
    }

    /**
     * @param InterfaceParamConfig $paramConfig
     * @return InterfaceParamConfig
     */
    public static function setParamConfig(InterfaceParamConfig $paramConfig):InterfaceParamConfig
    {
        return self::$paramConfig = $paramConfig;
    }

    /**
     * 获取组件内部使用的token处理对象
     * @return InterfaceToken
     */
    public static function getToken():InterfaceToken
    {
        if (empty(self::$token)) {
            throw new InvalidArgumentException('请先配置【token】值');
        }
        return self::$token;
    }

    /**
     * 设置组卷内部使用的jwt对象
     * @param InterfaceToken $token
     * @return InterfaceToken
     */
    public static function setToken(InterfaceToken $token):InterfaceToken
    {
        return self::$token = $token;
    }

    /**
     * 获取组件内用于处理接口发送的对象
     * @return InterfaceRequestSend
     */
    public static function getSendRequest():InterfaceRequestSend
    {
        if (empty(self::$sendRequest)) {
            throw new InvalidArgumentException('请先配置【sendRequest】值');
        }
        return self::$sendRequest;
    }

    /**
     * 设置组件内用于处理接口发送的对象
     * @param InterfaceRequestSend $sendRequest
     * @return InterfaceRequestSend
     */
    public static function setSendRequest(InterfaceRequestSend $sendRequest):InterfaceRequestSend
    {
        //todo
        return self::$sendRequest = $sendRequest;
    }
}
