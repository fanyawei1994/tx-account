<?php
/**
 * User: fanyawei
 * Date: 2023/12/29 17:36
 */

namespace Tesoon\Account\RequestSend\Request;

/**
 * 通过管理员id批量获取管理员信息
 * 使用示例：
 *
 * @see https://showdoc.tesoon.com/web/#/23/1081
 */
class AdminGetUserByIDs extends ApiRequestBase
{
    /**
     * @var string 接口地址
     */
    public $url = '/api/admin/get-user-by-ids';

    /**
     * @var string 接口请求方式
     */
    public $requestMethod = self::REQUEST_METHOD_GET;

    /**
     * 要查询的管理员ID数组
     * @param array $adminIDs
     * @return $this
     */
    public function setAdminIDs(array $adminIDs): self
    {
        $this->requestParams['ids'] = $adminIDs;
        return $this;
    }
}
