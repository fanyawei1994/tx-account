<?php
/**
 * User: fanyawei
 * Date: 2024/1/30 15:38
 */

namespace Tesoon\Account\Yii2\Models;

/**
 * Trait AccountIdentityTrait
 * @property int $id
 * @package common\account
 */
trait AccountIdentityTrait
{
    public static function findIdentity($id)
    {
        return null;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return '';
    }

    /**
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return false;
    }
}
