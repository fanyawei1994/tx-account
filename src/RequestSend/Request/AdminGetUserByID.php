<?php
/**
 * User: fanyawei
 * Date: 2023/12/29 16:56
 */

namespace Tesoon\Account\RequestSend\Request;

/**
 * 通过管理员ID获取单个管理员信息
 * 使用示例： $adminInfo = (new AdminGetUserByID())->setAdminID(133)->send()
 *
 * @see https://showdoc.tesoon.com/web/#/23/1080
 */
class AdminGetUserByID extends ApiRequestBase
{
    /**
     * @var string 接口地址
     */
    public $url = '/api/admin/get-user-by-id';

    /**
     * @var string 接口请求方式
     */
    public $requestMethod = self::REQUEST_METHOD_GET;

    /**
     * 设置要检索的管理员ID
     * @param int $adminID
     * @return $this
     */
    public function setAdminID(int $adminID): self
    {
        $this->requestParams['id'] = $adminID;
        return $this;
    }
}
