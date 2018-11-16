<?php
/**
 * Created by PhpStorm.
 * User: ifehrim@gmail.com
 * Date: 10/30/2018
 * Time: 18:07
 */

namespace Frame\Queue;


class Quer
{
    CONST TIMER = 1;
    CONST EXPECT = 2;
    CONST DAILY = 4;
    /**
     * @var \SplPriorityQueue
     */
    protected static $_scheduler;
    protected static $_timerId = 1;
    protected static $_eventTimer = [];
    protected static $calls;

    public static function init()
    {
        if (empty(self::$_scheduler)) {
            self::$_scheduler = new \SplPriorityQueue();
            self::$_scheduler->setExtractFlags(\SplPriorityQueue::EXTR_BOTH);
        }
    }


    public static function insert($fd, $func, $flag = self::TIMER)
    {
        self::init();
        $timer_id = self::$_timerId++;

        if ($flag === (self::TIMER | self::DAILY) || $flag === (self::EXPECT | self::DAILY)) {
            $run_time = self::time($fd);
        } else {
            $run_time = self::time() + $fd;
        }
        self::$_scheduler->insert($timer_id, -$run_time);
        self::$_eventTimer[$timer_id] = [$fd, $func, $flag, $timer_id];
        return $timer_id;
    }


    public static function remove($timer_id)
    {
        if (isset(self::$_eventTimer[$timer_id])) unset(self::$_eventTimer[$timer_id]);
    }

    public static function tick()
    {
        $_arr = [];
        while (!self::$_scheduler->isEmpty()) {
            $scheduler_data = self::$_scheduler->top();
            $timer_id = $scheduler_data['data'];
            $next_run_time = -$scheduler_data['priority'];
            $_arr[] = [$timer_id, $next_run_time];
            self::$_scheduler->extract();
        }

        foreach ($_arr as list($timer_id, $next_run_time)) {
            $time_now = self::time();
            $st = ($next_run_time - $time_now) * 100;
            if ($st <= 0) {
                if (!isset(self::$_eventTimer[$timer_id])) {
                    continue;
                }
                @list($fd, $func, $flag, $timer_id) = $arr = self::$_eventTimer[$timer_id];
                if ($flag === self::TIMER) {
                    self::$_scheduler->insert($timer_id, -($time_now + $fd));
                }
                if ($flag === self::EXPECT) {
                    @self::remove($timer_id);
                }
                if ($flag === (self::TIMER | self::DAILY)) {
                    self::$_scheduler->insert($timer_id, -(self::time($fd) + 60 * 60 * 24));
                }
                if ($flag === (self::EXPECT | self::DAILY)) {
                    @self::remove($timer_id);
                }
                @call_user_func_array($func, $arr);
            } else {
                self::$_scheduler->insert($timer_id, -$next_run_time);
            }
        }

    }


    public static function loop($call = null)
    {
        if (is_callable($call) && !empty($call)) static::on('loop', $call);
        self::init();
        while (true) {
            static::off('loop');
            self::tick();
            sleep(1);
        }
    }

    public static function on($func, callable $call = null)
    {
        self::$calls[$func] = $call;
    }

    public static function off($func, ...$params)
    {
        $res = null;
        if (isset(self::$calls[$func])) {
            try {
                $res = call_user_func_array(self::$calls[$func], $params);
            } catch (\Exception $e) {
                $tag = $func;
                $func = "error";
                if (isset(self::$calls[$func])) {
                    call_user_func(self::$calls[$func], $tag, $e, $params);
                }
            }
        }
        return $res;
    }


    private static function time($fd = null)
    {
        if ($fd === null) return time();
        return strtotime($fd);
    }

}