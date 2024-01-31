<?php
/**
 * User: fanyawei
 * Date: 2024/1/30 14:47
 */

namespace Tesoon\Account\Yii2;

use Lcobucci\JWT\Token;
use Tesoon\Account\AccountConfig;
use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;

/**
 * 一个在Yii2.0中通用的token处理示例
 */
abstract class AccountQueryParamAuth extends AuthMethod
{

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response)
    {
        $token = AccountConfig::getToken()->validateToken($this->getAccessToken($request));
        if ($token == false) {
            //token无效
            return null;
        }
        $userModel = $this->getUserModelByToken($token);
        $user->setIdentity($userModel);

        $this->setNewToken($token, $request, $response);
        return $userModel;
    }

    /**
     * 可以在此做一些处理
     * @param Token $newToken
     * @param Request $request
     * @param Response $response
     */
    abstract public function setNewToken(Token $newToken, Request $request, Response $response):void;

    /**
     * 传递的token
     * @param Request $request
     * @return string
     */
    abstract public function getAccessToken(Request $request):string;

    /**
     * 通过token获取user模型，可在具体项目中重构此方法返回具体项目的user模型
     * @param Token $token
     * @return IdentityInterface
     */
    abstract public function getUserModelByToken(Token $token):IdentityInterface;
}
