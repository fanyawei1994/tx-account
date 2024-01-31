<?php
/**
 * User: fanyawei
 * Date: 2024/1/30 15:35
 */

namespace Tesoon\Account\Yii2\Models;

use yii\base\Model;
use yii\web\IdentityInterface;

class AccountAdmin extends Model implements IdentityInterface
{
    use AccountIdentityTrait;

    /**
     * 用户id
     * @var int
     */

    public $id;

    /**
     * 用户昵称
     * @var string
     */
    public $nickname;

    /**
     * 用户真实姓名
     * @var string
     */
    public $realname;

    /**
     * 用户名
     * @var string
     */
    public $username;

    /**
     * 性别 0保密 1男 2女
     * @var int
     */
    public $sex;

    /**
     * 手机号
     * @var int
     */
    public $phone;

    /**
     * 邮箱
     * @var string
     */
    public $email;

    /**
     * 状态 0正常 1禁用
     * @var int
     */
    public $status;

    /**
     * 状态 0正常 1禁用
     * @var int
     */
    public $pic;
}
