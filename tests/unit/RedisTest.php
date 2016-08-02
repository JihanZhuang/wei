<?php

namespace WeiTest;

class RedisTest extends CacheTestCase
{
    public function setUp()
    {
        if (!extension_loaded('redis') || !class_exists('\Redis')) {
            $this->markTestSkipped('The "redis" extension is not loaded');
        }

        parent::setUp();

        try {
            $this->object->get('test');
        } catch (\RedisException $e) {
            $this->markTestSkipped('The redis server is not running');
        }

        /** @var \Redis $redis */
        $redis = $this->object->getObject();
        $error = $redis->getLastError();
        if ($error) {
            $this->markTestSkipped('Redis error: ' . $error);
        }

        $redis = new \Redis();
        $result = $redis->connect('127.0.0.1', '6379', 0.0);
        if ($result) {
            $this->markTestSkipped('Redis connect error: ' . $redis->getLastError());
        }
    }

    public function testIncrAndDecr()
    {
        $redis = $this->object->getObject();
        $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);

        parent::testIncrAndDecr();
    }

    public function testPrefix()
    {
        $redis = $this->object->getObject();
        $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_NONE);

        parent::testPrefix();
    }

    public function testGetAndSetObject()
    {
        $cache = $this->object;
        $redis = $cache->getObject();

        $this->assertInstanceOf('\Redis', $redis);

        $cache->setObject($redis);

        $this->assertInstanceOf('\Redis', $cache->getObject());
    }

    public function testGetRedisObject()
    {
        $this->assertInstanceOf('\Redis', $this->redis());
    }

    public function testConnectWithExistsObject()
    {
        $this->assertTrue($this->object->connect());
    }
}
