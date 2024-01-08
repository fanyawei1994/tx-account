<?php
/**
 * User: fanyawei
 * Date: 2024/1/3 16:52
 */
namespace Tesoon\Account\Token;

use DateTimeImmutable;
use Exception;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Claim\Basic;
use Lcobucci\JWT\Token;
use Tesoon\Account\AccountConfig;
use Tesoon\Account\ApiHelper;
use Tesoon\Account\BaseObject;
use Tesoon\Account\InterfaceToken;
use Tesoon\Account\Token\Jwt\Jwt;

/**
 * Class DefaultJwt
 * @package Tesoon\Account\JWT
 */
class JwtToken extends BaseObject implements InterfaceToken
{

    /**
     * @var Jwt
     */
    public $jwt;

    /**
     * @var string jwtAlg
     */
    public $jwtAlg = 'HS256';

    /**
     * @return Jwt
     */
    public function getJwt():Jwt
    {
        if (!empty($this->jwt)) {
            return $this->jwt;
        }
        $this->jwt = new Jwt();
        $this->jwt->key = AccountConfig::getParamConfigValue('jwtToken.key');
        return $this->jwt;
    }

    /**
     * 生成一个token
     * @param array $params
     * @return string
     */
    public function generateToken(array $params = []):string
    {
        $jwt = $this->getJwt();
        if (!isset($params['key']) || !isset($params['jti'])) {
            exit('缺失必要参数');
        }
        if (!isset($params['iat'])) {
            $params['iat'] = time();
        }
        if (!isset($params['nbf'])) {
            $params['nbf'] = $params['iat'];
        }
        if (!isset($params['exp'])) {
            $params['exp'] = $params['iat'] + 1;
        }

        $signer = $jwt->getSigner($this->jwtAlg);
        $token = $jwt->getBuilder()
            ->identifiedBy($params['jti'])//jwt的唯一身份标识
            ->issuedAt(new DateTimeImmutable('@' . $params['iat'])) //jwt的签发时间
            ->canOnlyBeUsedAfter(new DateTimeImmutable('@' . $params['nbf'])) // 定义在什么时间之前，该jwt都是不可用的.
            ->expiresAt(new DateTimeImmutable('@' . $params['exp'])) // jwt的过期时间，这个过期时间必须要大于签发时间
            ->withClaim('lastValidateTime', time());//记录上次验证时间

        if (isset($params['iss'])) {
            $token->issuedBy($params['iss']); //jwt签发者
        }
        if (isset($params['aud'])) {
            $token->permittedFor($params['aud']); // 接收jwt的一方
        }
        if (!empty($params['claims']) && is_array($params['claims'])) {
            foreach ($params['claims'] as $key => $value) {
                $token->withClaim($key, $value);
            }
        }
        return (string) $token->getToken($signer, $jwt->getKey($params['key']));
    }

    /**
     * 验证token有效性
     * @param $token
     * @return bool|Token
     */
    public function validateToken($token)
    {
        //验证token有效截至时间，如不验证则设置为false
        $validate = AccountConfig::getParamConfigValue('jwtToken.validate', true);
        //验证token的合法性，如不验证设置为false
        $verify = AccountConfig::getParamConfigValue('jwtToken.verify', true);
        //向token签发服务器验证jti有效性的时间间隔
        $jtiInterval = AccountConfig::getParamConfigValue('jwtToken.jtiInterval', 60);

        try {
            if (empty($token = $this->getJwt()->loadToken($token, $validate, $verify))) {
                return false;
            }

            //如果距上次验证数据有效性超过一分钟，就去用户服务器验证数据有效性
            if ($token->getClaim('lastValidateTime', 0) < time() - $jtiInterval) {
                $buffer = ApiHelper::indexValidateJti($token->getClaim('jti'));

                if (empty($buffer['status'])) {
                    return false;
                }
                $params = [
                    'identity' => $buffer['identity'],
                    'exp' => time() + $buffer['authTimeout'],
                    'lastValidateTime' => time(),
                ];
                $token = $this->generateResponseToken($token, $params);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return $token;
    }

    /**
     * 通过已有token对象更新一些值生成一个新的token
     * @param Token $token
     * @param array $claims
     * @return Token
     */
    public function generateResponseToken(Token $token, array $claims = []): Token
    {
        $jwt = $this->getJwt();
        $newToken = $jwt->getBuilder();
        foreach ($token->getHeaders() as $key => $value) {
            if ($value instanceof Basic) {
                $value = $value->getValue();
            }
            $newToken->withHeader($key, $value);
        }
        foreach ($token->getClaims() as $key => $value) {
            if ($value instanceof Basic) {
                $value = $value->getValue();
            }
            self::tokenWithClaim($newToken, $key, $value);
        }
        foreach ($claims as $key => $value) {
            self::tokenWithClaim($newToken, $key, $value);
        }

        return $newToken->getToken($jwt->getSigner($token->getHeader('alg')), $jwt->getKey());
    }

    /**
     * 设置token配置属性值
     * @param Builder $builder
     * @param string $key
     * @param mixed $value
     */
    public static function tokenWithClaim(Builder $builder, string $key, $value):void
    {
        switch ($key) {
            case Token\RegisteredClaims::AUDIENCE:
                $builder->setAudience($value);
                return;
            case Token\RegisteredClaims::EXPIRATION_TIME:
                $builder->expiresAt(new DateTimeImmutable('@' . $value));
                return;
            case Token\RegisteredClaims::ID:
                $builder->identifiedBy($value);
                return;
            case Token\RegisteredClaims::ISSUED_AT:
                $builder->issuedAt(new DateTimeImmutable('@' . $value));
                return;
            case Token\RegisteredClaims::ISSUER:
                $builder->issuedBy($value);
                return;
            case Token\RegisteredClaims::NOT_BEFORE:
                $builder->canOnlyBeUsedAfter(new DateTimeImmutable('@' . $value));
                return;
            case Token\RegisteredClaims::SUBJECT:
                $builder->setSubject($value);
                return;
        }
        $builder->withClaim($key, $value);
    }
}
