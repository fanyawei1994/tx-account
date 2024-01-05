<?php
/**
 * User: fanyawei
 * Date: 2024/1/5 14:15
 */
namespace Tesoon\Account\Logs;

use Tesoon\Account\BaseObject;
use Tesoon\Account\InterfaceLog;

class DefaultLog extends BaseObject implements InterfaceLog
{
    /**
     * @var int 日志中记录调用堆栈信息（文件名和线路号）的数量，默认0不记录
     */
    public $traceLevel = 1;

    /**
     * @var bool 是否debug环境，如果为true则记录debug日志，否则忽略debug日志的记录，默认false不记录
     */
    public $debug = false;

    /**
     * @var array
     */
    private $messages = [];

    /**
     * 获取所有已记录的日志信息
     * @param int $levels 默认0查询所有级别日志
     * @param array $categories
     * @param array $except
     * @return array
     */
    public function getLogs(int $levels = 0, array $categories = [], array $except = []):array
    {
        $data = [];
        foreach ($this->messages as $message) {
            if ($levels && !($levels & $message[1])) {
                continue;
            }
            $matched = empty($categories);
            foreach ($categories as $category) {
                if ($message[2] === $category
                    || !empty($category)
                    && substr_compare($category, '*', -1, 1) === 0
                    && strpos($message[2], rtrim($category, '*')) === 0
                ) {
                    $matched = true;
                    break;
                }
            }
            if ($matched) {
                foreach ($except as $category) {
                    $prefix = rtrim($category, '*');
                    if (($message[2] === $category || $prefix !== $category) && strpos($message[2], $prefix) === 0) {
                        $matched = false;
                        break;
                    }
                }
            }
            if ($matched) {
                $data[] = $message;
            }
        }
        return $data;
    }

    /**
     * 清空日志
     */
    public function removeAll():void
    {
        $this->messages = [];
    }

    /**
     * @param string|array $message
     * @param string $category
     */
    public function debug($message, string $category = 'TxAccount'):void
    {
        if ($this->debug) {
            $this->log($message, self::LEVEL_TRACE, $category);
        }
    }

    /**
     * @param string|array $message
     * @param string $category
     */
    public function error($message, string $category = 'TxAccount'):void
    {
        $this->log($message, self::LEVEL_ERROR, $category);
    }

    /**
     * @param string|array $message
     * @param string $category
     */
    public function warning($message, string $category = 'TxAccount'):void
    {
        $this->log($message, self::LEVEL_WARNING, $category);
    }

    /**
     * @param string|array $message
     * @param string $category
     */
    public function info($message, string $category = 'TxAccount'):void
    {
        $this->log($message, self::LEVEL_INFO, $category);
    }

    /**
     *
     * @param string|array $message
     * @param int $level
     * @param string $category
     */
    public function log($message, int $level, string $category = 'TxAccount')
    {
        $time = microtime(true);
        $traces = [];
        if ($this->traceLevel > 0) {
            $count = 0;
            $ts = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            array_pop($ts); // remove the last trace since it would be the entry script, not very useful
            foreach ($ts as $trace) {
                if (isset($trace['file'], $trace['line']) && strpos($trace['file'], __FILE__) !== 0) {
                    unset($trace['object'], $trace['args']);
                    $traces[] = $trace;
                    if (++$count >= $this->traceLevel) {
                        break;
                    }
                }
            }
        }
        $this->messages[] = [$message, $level, $category, $time, $traces, memory_get_usage()];
    }
}
