<?php
/**
 * User: fanyawei
 * Date: 2024/1/4 15:36
 */

namespace Tesoon\Account\Exceptions;

use Exception;

/**
 * 组件内部的基础异常类
 */
class ExceptionAccount extends Exception
{
    /**
     * @return string
     */
    public function getName()
    {
        return 'ExceptionAccount';
    }
}
