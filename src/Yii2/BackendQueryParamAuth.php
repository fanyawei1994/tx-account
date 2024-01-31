<?php
/**
 * User: fanyawei
 * Date: 2024/1/30 15:18
 */

namespace Tesoon\Account\Yii2;

use Lcobucci\JWT\Token;
use Tesoon\Account\Yii2\Models\AccountAdmin;
use yii\base\Model;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;

/**
 * 后台由后端人员自己开发通过cookie传递token时的处理示例
 */
class BackendQueryParamAuth extends AccountQueryParamAuth
{
    /**
     * @var string
     */
    public $tokenName = '';

    /**
     * 获取token
     * @param Request $request
     * @return string
     */
    public function getAccessToken(Request $request): string
    {
        return $request->cookies->getValue($this->tokenName, '');
    }

    /**
     * 设置新token
     * @param Token $newToken
     * @param Request $request
     * @param Response $response
     */
    public function setNewToken(Token $newToken, Request $request, Response $response): void
    {
        $cookie = $request->cookies->get($this->tokenName);
        if (!empty($cookie) && $cookie->value != $newToken) {
            $cookie->value = (string)$newToken;
            $cookie->expire = $newToken->getClaim('exp');
            $response->cookies->add($cookie);
        }
    }

    /**
     * @param Token $token
     * @return IdentityInterface
     */
    public function getUserModelByToken(Token $token): IdentityInterface
    {
        $userIdentityData = $token->getClaim('identity');
        /* @var $userIdentity IdentityInterface|Model*/
        $userIdentity = new AccountAdmin();
        $userIdentity->setAttributes((array)$userIdentityData, false);
        return $userIdentity;
    }
}
