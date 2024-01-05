<?php
/**
 * User: fanyawei
 * Date: 2024/1/5 11:45
 */

namespace Tesoon\Account;

/**
 * Log记录
 */
interface InterfaceLog
{

    const LEVEL_ERROR = 0x01;
    const LEVEL_WARNING = 0x02;
    const LEVEL_INFO = 0x04;
    const LEVEL_TRACE = 0x08;

    /**
     * 获取所有已记录的日志信息
     * @param int $levels InterfaceLog::LEVEL_WARNING|InterfaceLog::LEVEL_ERROR
     * @param array $categories
     * @param array $except
     * @return array
     */
    public function getLogs(int $levels = 0, array $categories = [], array $except = []):array;

    /**
     * 清空日志
     */
    public function removeAll():void;

    /**
     * @param string|array|object $message
     * @param string $category
     */
    public function debug($message, string $category = 'TxAccount'):void;

    /**
     * @param string|array|object $message
     * @param string $category
     */
    public function error($message, string $category = 'TxAccount'):void;

    /**
     * @param string|array|object $message
     * @param string $category
     */
    public function warning($message, string $category = 'TxAccount'):void;

    /**
     * @param string|array|object $message
     * @param string $category
     */
    public function info($message, string $category = 'TxAccount'):void;
}
