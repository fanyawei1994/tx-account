<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 11:44
 */

namespace Tesoon\Account;

use Tesoon\Account\RequestSend\Request\ApiRequestBase;

/**
 * 发送请求处理逻辑类
 * @package Tesoon\Account
 */
interface InterfaceRequestSend
{
    /**
     * @param ApiRequestBase $request
     * @param bool $raw 默认false如果响应正文包含 JSON则进行解码
     * @return mixed
     */
    public function send(ApiRequestBase $request, bool $raw = false);
}
