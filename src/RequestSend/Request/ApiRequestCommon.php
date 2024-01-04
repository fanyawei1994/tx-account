<?php
/**
 * User: fanyawei
 * Date: 2024/1/4 9:17
 */

namespace Tesoon\Account\RequestSend\Request;

/**
 * 一个通用的Api请求类，当新增接口但组件尚未更新没有指定接口请求类时使用
 */
class ApiRequestCommon extends ApiRequestBase
{

    /**
     * 设置请求url
     * @param string $url
     * @return $this
     */
    public function setApiUrl(string $url):self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * 设置请求方式
     * @param string $requestMethod
     * @return $this
     */
    public function setApiRequestMethod(string $requestMethod):self
    {
        $this->requestMethod = $requestMethod;
        return $this;
    }

    /**
     * 设置请求参数
     * @param array $requestParams
     * @return $this
     */
    public function setApiRequestParams(array $requestParams):self
    {
        $this->requestParams = $requestParams;
        return $this;
    }
}
