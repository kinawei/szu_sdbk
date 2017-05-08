<?php
	
    /**
     * Class RedisConnManager
     *
     * 单例模式对redis实例的操作的进一步封装
     * 主要目的：防止过多的连接，一个页面只能存在一个声明连接
     * 
     */
    class RedisManager
    {
        private static $redisInstance;

        /**
         * 私有化构造函数
         * 原因：防止外界调用构造新的对象
         */
        private function __construct(){}

        /**
         * 获取redis连接的唯一出口
         */
        static public function getRedisConn(){
            if(!self::$redisInstance instanceof self){
                self::$redisInstance = new self;
            }


            // 获取当前单例
            $temp = self::$redisInstance;
            // 调用私有化方法
            return $temp->connRedis();
        }

        /**
         * 连接ocean 上的redis的私有化方法
         * @return Redis
         */
        static private function connRedis()
        {
            try {
                $redis_ocean = new Redis();
                $redis_ocean->connect('cslbcygunuof.redis.sae.sina.com.cn',10581);
                $redis_ocean->auth('AN0l4iNjveqF54TgtTOBOV3IOjLeGCuHSMZz6tpMDQLBkiAKIXTym7kgLnEwPePa');
            }catch (Exception $e){
                echo $e->getMessage().'<br/>';
            }

            return $redis_ocean;
        }

    }
	