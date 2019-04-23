<?php

/**
 * TP框架本地的file缓存只能在生成缓存时添加过期时间，而且不能对生成的缓存的过期时间进行修改，所以我添加了一个设置过期时间的方法
 * TP版本是5.0.23
 */

/**
 * 先添加方法在thinkphp\library\think\Cache.php
 */

/**
 * 给缓存设置过期时间
 * @param  string $name 缓存变量名
 * @param integer|\DateTime $expire  有效时间（秒）
 * @return bool
 */
public static function expire($name, $expire = null)
{
    self::$readTimes++;

    return self::init()->expire($name, $expire);
}

/**
 * 再添加方法在thinkphp\library\think\cache\driver\File.php
 */

/**
 * 给缓存设置过期时间
 * @access public
 * @param string $name 缓存变量名
 * @param integer|\DateTime $expire  有效时间（秒）
 * @return bool
 */
public function expire($name, $expire = null)
{
    if (!is_null($expire)) {
        if ($expire instanceof \DateTime) {
            $expire = $expire->getTimestamp() - time();
        }
        if ($this->has($name)) {
            $value = $this->get($name);
            return $this->set($name, $value, $expire) ? true : false;
        }
    } else {
        if ($this->has($name)) {
            $value = $this->get($name);
            $expire = $this->options['expire'];
            return $this->set($name, $value, $expire) ? true : false;
        }
    }
    return false;
}

/**
 * 使用设置过期方法
 */

use think\Cache;

Cache::expire($key, $expire_time);