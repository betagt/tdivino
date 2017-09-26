<?php
/**
 * Created by PhpStorm.
 * User: pc05
 * Date: 12/06/2017
 * Time: 17:43
 */

namespace Portal\Services;


class CacheService
{
    private $cache;

    public function __construct(\Illuminate\Cache\Repository $cache )
    {
        $this->cache = $cache;
    }

    public function getCache(){
        return $this->cache;
    }

    public function has($key){
        return $this->getCache()->has($key);
    }

    public function forget($key){
        return $this->getCache()->forget($key);
    }

    public function put($key,$value,$minuts=1){
        try{
            $cache = $this->getCache();
            $cache->put($key,$value,$minuts);
            return true;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function get($key, $default = null){
        return $this->getCache()->get($key, $default);
    }
}