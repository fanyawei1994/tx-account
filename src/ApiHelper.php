<?php
/**
 * User: fanyawei
 * Date: 2024/1/4 17:18
 */

namespace Tesoon\Account;

use Tesoon\Account\Exceptions\ExceptionAccount;
use Tesoon\Account\RequestSend\ApiRequestCommon;

/**
 * 一些封装好的api接口调用方式
 */
class ApiHelper
{

    /**
     * 通过管理员id获取管理员信息
     * @param int $adminID
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1080
     */
    public static function adminGetUserByID(int $adminID):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/get-user-by-id');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'id' => $adminID
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 通过管理员id批量获取管理员信息
     * @param array $adminIDs
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1081
     */
    public static function adminGetUserByIDs(array $adminIDs):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/get-user-by-ids');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'ids' => $adminIDs
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 管理员分页筛选
     * $data = ApiHelper::adminUserList([
     *     'per-page' => 8,
     *     'page' => 1,
     *     'sort' => 'id',
     *     'id' => 132,
     * ]);
     * @param array $params
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1082
     */
    public static function adminUserList(array $params):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/user-list');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 管理员筛选条件，返回管理员id和用户名
     * @param array $params
     * @return array
     */
    public static function adminFormSelect(array $params = []):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/form-select');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 修改管理员信息
     * $data = ApiHelper::adminUpdateInfo(245679, [
     *     'nickname' => 'testCreateNickName1',
     *     'realname' => 'testCreateRealName1',
     *     'password' => '123456781',
     *     'pic' => '111.pic',
     *     'phone' => '15211112223',
     *     'email' => '222@163.com',
     *     'sex' => 2,//性别 1男 2女 默认0保密
     *     'status' => 1,//如果要修改状态传此字段 0正常 1禁用
     * ]);
     * @param int $adminID
     * @param array $updateParams
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1084
     */
    public static function adminUpdateInfo(int $adminID, array $updateParams)
    {
        if (empty($adminID)) {
            throw new ExceptionAccount('管理员ID不能为空');
        }
        $params = array_merge($updateParams, ['adminID' => $adminID]);
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/update-info');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 添加管理员
     * $data = ApiHelper::adminCreate([
     *     'username' => 'testCreate',
     *     'nickname' => 'testCreateNickName',
     *     'realname' => 'testCreateRealName',
     *     'password' => '12345678',
     *     'phone' => '15211112222',
     *     'email' => '111@163.com',
     *     'sex' => 1,//性别 1男 2女 默认0保密
     *     'created_ip' => '11.22.33.44',
     *     'created_admin' => '1',
     * ]);
     * @param array $createParams
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/2430
     */
    public static function adminCreate(array $createParams):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/create');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($createParams);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * @param string $userName
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/3740
     */
    public static function adminGenerateTokenByUsername(string $userName):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/generate-token-by-username');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams([
            'username' => $userName
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * @param array $usernames
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/4072
     */
    public static function adminGetUserByNames(array $usernames):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/admin/get-user-by-names');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'names' => $usernames
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 获得单个用户信息
     * @param int $userID
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1087
     */
    public static function userGetUserByID(int $userID):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/get-user-by-id');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'id' => $userID
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 批量获取用户信息（ids）
     * @param array $userIDs
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1089
     */
    public static function userGetUserByIDs(array $userIDs):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/get-user-by-ids');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'ids' => $userIDs
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 批量获取用户信息(names)
     * @param array $usernames
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1090
     */
    public static function userGetUserByNames(array $usernames):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/get-user-by-names');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'names' => $usernames
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 用户分页筛选
     * $data = ApiHelper::userList([
     *    'per-page' => 2,//每页返回分页数量
     *    'page' => 1,
     *    'id' => '37290',
     *    'username' => '15286838645',
     *    'sex' => 1,//筛选性别 0保密 1男 2女
     *    'phone' => '12546453333',
     *    'status' => 1,//筛选状态 0正常 1禁用
     *    'notIn' => '1,2,3,4,5,6',//配置返回结果不包含此处设置的用户id，多个用英文逗号隔开
     *    'in' => '1,2,3,4,5,6',//配置返回结果必须包含在此处配置的用户id中，多个用英文逗号隔开
     *    'lastTimeFilterStart' => strtotime('2023-11-1'),//检索最后登录时间戳大于此值的用户
     *    'lastTimeFilterEnd' => strtotime('2023-12-1'),//检索最后登录时间戳小于此值的用户
     *    'createTimeFilterStart' => strtotime('2023-11-1'),//检索创建时间戳大于此值的用户
     *    'createTimeFilterEnd' => strtotime('2023-12-1'),//检索创建时间戳小于此值的用户
     * ]);
     * @param array $params
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1096
     */
    public static function userList(array $params):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/user-list');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 修改用户信息
     * @param int $userID
     * @param array $updateParams
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1097
     */
    public static function userUpdateInfo(int $userID, array $updateParams)
    {
        $params = array_merge($updateParams, [
            'userID' => $userID,
        ]);
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/update-info');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 新增用户
     * @param array $params
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1098
     */
    public static function userCreate(array $params):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/create');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 重置密码（通过旧密码）
     * @param int $userID
     * @param string $oldPassword
     * @param string $newPassword
     * @param string $newPassword2
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/4064
     */
    public static function userResetPassword(
        int $userID,
        string $oldPassword,
        string $newPassword,
        string $newPassword2
    ):array {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/reset-password');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams([
            'userID' => $userID,
            'oldPassword' => $oldPassword,
            'newPassword' => $newPassword,
            'newPassword2' => $newPassword2,
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 用户登录日志列表
     * @param int $userID
     * @param array $types 0网页 1APP 2小程序 3h5
     * @param int $limit
     * @param string $token
     * @return array
     */
    public static function userLoginLogs(int $userID, array $types, int $limit = 10, string $token = ''):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/login-logs');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams([
            'userID' => $userID,
            'types' => $types,
            'token' => $token,
            'limit' => $limit,
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 用户注销
     * @param int $userID
     * @return mixed
     */
    public static function userCancel(int $userID)
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/cancel');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams([
            'userID' => $userID
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 收货地址列表
     * @param int $userID
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1100
     */
    public static function userAddressList(int $userID):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/address-list');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'userID' => $userID
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 创建用户收货地址
     * $data = ApiHelper::userAddressCreate(37290, [
     *     'region_id' => '1260',//地区id
     *     'address' => '***街道****小区',//详细地址
     *     'receiver' => '张三',//收件人
     *     'phone' => '15211112222',//收件人手机号
     *     'postcode' => '',//邮编，不知道不传此参数
     *     'default_address' => '1',//是否设定为默认收货地址 0不默认 1默认
     * ]);
     * @param int $userID
     * @param array $createParams
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1101
     */
    public static function userAddressCreate(int $userID, array $createParams):array
    {
        $params = array_merge($createParams, [
            'userID' => $userID,
        ]);
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/address-create');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 修改用户收货地址信息
     * $data  = ApiHelper::userAddressUpdate(1509, [
     *     'region_id' => '1260',//地区id
     *     'address' => '***街道****小区111',//详细地址
     *     'receiver' => '张三1',//收件人
     *     'phone' => '15211113333',//收件人手机号
     *     'postcode' => '',//邮编，不知道不传此参数
     *     'default_address' => '0',//是否设定为默认收货地址 0不默认 1默认
     * ]);
     * @param int $addressID
     * @param array $updateParams
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1102
     */
    public static function userAddressUpdate(int $addressID, array $updateParams)
    {
        $params = array_merge($updateParams, [
            'addressID' => $addressID,
        ]);
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/address-update');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams($params);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 删除用户收货地址
     * @param int $userID
     * @param int $addressID
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1103
     */
    public static function userAddressDelete(int $userID, int $addressID)
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/address-delete');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'userID' => $userID,
            'addressID' => $addressID,
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 获取用户默认收货地址
     * 默认优先返回设定为默认的，没有默认返回最后修改的一个
     * @param int $userID
     * @return array
     * @see https://showdoc.tesoon.com/web/#/23/1105
     */
    public static function userDefaultAddress(int $userID):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/default-address');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'userID' => $userID
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 修改是否默认
     * @param int $addressID
     * @param int $isDefault
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1106
     */
    public static function userSetDefault(int $addressID, int $isDefault)
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/set-default');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_POST);
        $request->setApiRequestParams([
            'addressID' => $addressID,
            'isDefault' => $isDefault,
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 获得指定收货地址信息
     * @param int $addressID
     * @return mixed
     * @see https://showdoc.tesoon.com/web/#/23/1107
     */
    public static function userGetOneAddress(int $addressID)
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/user/get-one-address');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'addressID' => $addressID,
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 校验token消息
     * @param string $jti
     * @return array
     */
    public static function indexValidateJti(string $jti):array
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/index/validate-jti');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'token' => $jti
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }

    /**
     * 后台管理员退出登录，使传入token失效
     * @param string $jti
     * @return mixed
     */
    public static function indexLogout(string $jti)
    {
        $request = new ApiRequestCommon();
        $request->setApiUrl('/api/index/logout');
        $request->setApiRequestMethod(ApiRequestCommon::REQUEST_METHOD_GET);
        $request->setApiRequestParams([
            'token' => $jti
        ]);
        return AccountConfig::getSendRequest()->send($request);
    }
}
