<?php
/**
 * User: fanyawei
 * Date: 2023/12/29 16:56
 */

namespace Tesoon\Account\RequestSend;

use Tesoon\Account\BaseObject;

/**
 * Class ApiRequestBase
 * @package fanyawei\txAccount\apiRequest
 */
abstract class ApiRequestBase extends BaseObject
{
    /**
     * 请求方式
     */
    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';

    /**
     * @var string 请求接口地址，如：/api/admin/get-user-by-id
     */
    public $url;

    /**
     * @var string 请求方式
     */
    public $requestMethod;

    /**
     * @var array 接口请求参数
     */
    public $requestParams = [];

    /**
     * 请求options
     * @return array
     */
    public function getRequestOptions():array
    {
        return [];
    }

    /**
     * 请求headers
     * @return array
     */
    public function getRequestHeaders():array
    {
        return [];
    }
}
