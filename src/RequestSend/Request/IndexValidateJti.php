<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 17:37
 */

namespace Tesoon\Account\RequestSend\Request;

/**
 * 验证token中jti的有效性
 */
class IndexValidateJti extends ApiRequestBase
{

    /**
     * @var string 接口地址
     */
    public $url = '/api/index/validate-jti';

    /**
     * @var string 接口请求方式
     */
    public $requestMethod = self::REQUEST_METHOD_GET;

    /**
     * 设置要检索的管理员ID
     * @param string $jti
     * @return $this
     */
    public function setJti(string $jti): self
    {
        $this->requestParams['token'] = $jti;
        return $this;
    }
}
