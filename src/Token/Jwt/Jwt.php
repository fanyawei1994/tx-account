<?php

namespace Tesoon\Account\Token\Jwt;

use InvalidArgumentException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Claim\Factory as ClaimFactory;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Parsing\Decoder;
use Lcobucci\JWT\Parsing\Encoder;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac as Hmac;
use Lcobucci\JWT\Signer\Ecdsa as Ecdsa;
use Lcobucci\JWT\Signer\Rsa as Rsa;
use RuntimeException;

/**
 * JSON Web Token implementation, based on this library:
 * https://github.com/lcobucci/jwt
 *
 * @author Dmitriy Demin <sizemail@gmail.com>
 * @since 1.0.0-a
 */
class Jwt
{

    /**
     * @var array Supported algorithms
     */
    public $supportedAlgs = [
        'HS256' => Hmac\Sha256::class,
        'HS384' => Hmac\Sha384::class,
        'HS512' => Hmac\Sha512::class,
        'ES256' => Ecdsa\Sha256::class,
        'ES384' => Ecdsa\Sha384::class,
        'ES512' => Ecdsa\Sha512::class,
        'RS256' => Rsa\Sha256::class,
        'RS384' => Rsa\Sha384::class,
        'RS512' => Rsa\Sha512::class,
    ];

    /**
     * @var Key|string $key The key
     */
    public $key;

    /**
     * @see [[Lcobucci\JWT\Builder::__construct()]]
     * @param Encoder|null $encoder
     * @param ClaimFactory|null $claimFactory
     * @return Builder
     */
    public function getBuilder(Encoder $encoder = null, ClaimFactory $claimFactory = null)
    {
        return new Builder($encoder, $claimFactory);
    }

    /**
     * @see [[Lcobucci\JWT\Parser::__construct()]]
     * @param Decoder|null $decoder
     * @param ClaimFactory|null $claimFactory
     * @return Parser
     */
    public function getParser(Decoder $decoder = null, ClaimFactory $claimFactory = null)
    {
        return new Parser($decoder, $claimFactory);
    }

    /**
     * @param string $alg
     * @return Signer
     */
    public function getSigner(string $alg): Signer
    {
        $class = $this->supportedAlgs[$alg];
        return new $class();
    }

    /**
     * @param string|null $content
     * @param string|null $passphrase
     * @return Key
     */
    public function getKey(string $content = null, string $passphrase = null): Key
    {
        $content = $content ?: $this->key;

        if ($content instanceof Key) {
            return $content;
        }

        return new Key($content, $passphrase);
    }

    /**
     * Parses the JWT and returns a token class
     * @param string $token JWT
     * @param bool $validate
     * @param bool $verify
     * @return Token|null
     * @throws \Throwable
     */
    public function loadToken(string $token, bool $validate = true, bool $verify = true)
    {
        try {
            $token = $this->getParser()->parse($token);
        } catch (RuntimeException | InvalidArgumentException $e) {
            return null;
        }

        if ($validate && !$this->validateToken($token)) {
            return null;
        }

        if ($verify && !$this->verifyToken($token)) {
            return null;
        }

        return $token;
    }

    /**
     * Validate token
     * @param Token $token token object
     * @param int|null $currentTime
     * @return bool
     */
    public function validateToken(Token $token, int $currentTime = null): bool
    {
        $validationData = new ValidationData($currentTime, 0);
        return $token->validate($validationData);
    }

    /**
     * Validate token
     * @param Token $token token object
     * @return bool
     * @throws \Throwable
     */
    public function verifyToken(Token $token): bool
    {
        $alg = $token->getHeader('alg');

        if (empty($this->supportedAlgs[$alg])) {
            throw new InvalidArgumentException('Algorithm not supported');
        }

        /** @var Signer $signer */
        $signer = new $this->supportedAlgs[$alg]();

        return $token->verify($signer, $this->getKey());
    }
}
