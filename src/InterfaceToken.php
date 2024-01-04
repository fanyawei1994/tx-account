<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 11:42
 */

namespace Tesoon\Account;

use Lcobucci\JWT\Token;

/**
 * JWT处理逻辑接口
 * @package Tesoon\Account
 */
interface InterfaceToken
{

    /**
     * 生成一个token
     * @param array $params
     * @return string
     */
    public function generateToken(array $params = []):string;

    /**
     * 验证token有效性
     * @param $token
     * @return bool|Token
     */
    public function validateToken($token);
}
