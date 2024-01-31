<?php
/**
 * User: fanyawei
 * Date: 2024/1/31 10:04
 */

namespace Tesoon\Account\Yii2;

use Lcobucci\JWT\Token;
use Tesoon\Account\Yii2\Models\AccountAdmin;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;

/**
 * 在header中传递的token的一个示例用法
 */
class TokenQueryParamAuth extends AccountQueryParamAuth
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
        return $request->headers->get($this->tokenName, '');
    }

    /**
     * 设置新token
     * @param Token $newToken
     * @param Request $request
     * @param Response $response
     */
    public function setNewToken(Token $newToken, Request $request, Response $response): void
    {
        $oldToken = $this->getAccessToken($request);
        if (!empty($oldToken) && $oldToken != $newToken) {
            $response->headers->set($this->tokenName, (string)$newToken);
        }
    }

    /**
     * @param Token $token
     * @return IdentityInterface
     */
    public function getUserModelByToken(Token $token): IdentityInterface
    {
        $userIdentityData = $token->getClaim('identity');
        /* @var $userIdentity IdentityInterface|AccountAdmin*/
        $userIdentity = new AccountAdmin();
        $userIdentity->id = $userIdentityData['id'];
        $userIdentity->username = $userIdentityData['username'];
        return $userIdentity;
    }
}
