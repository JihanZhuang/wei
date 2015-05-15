<?php
/**
 * Wei Framework
 *
 * @copyright   Copyright (c) 2008-2015 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */
namespace Wei;

/**
 * A cache service that support tagging
 *
 * @property \Wei\BaseCache $cache
 */
class TagCache extends BaseCache
{
    /**
     * The names of tag
     *
     * @var array
     */
    protected $tags = array();

    /**
     * Create a new cache service with tagging support
     *
     * @param string $tag
     * @param mixed $_
     * @param mixed $_
     * @return static
     */
    public function __invoke($tag, $_ = null, $_ = 0)
    {
        $tags = is_array($tag) ? $tag : func_get_args();
        return new static(array(
            'wei' => $this->wei,
            'tags' => $tags
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $expire = null, $fn = null)
    {
        return $this->cache->get($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, $expire = 0)
    {
        return $this->cache->set($this->getKey($key), $value, $expire);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        return $this->cache->remove($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key)
    {
        return $this->cache->exists($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, $expire = 0)
    {
        return $this->cache->exists($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, $expire = 0)
    {
        return $this->cache->exists($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function incr($key, $offset = 1)
    {
        return $this->cache->exists($this->getKey($key));
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        foreach ($this->tags as $tag) {
            $this->cache->set($this->getTagKey($tag), $this->generateTagValue());
        }
        return $this;
    }

    /**
     * @param string $key
     * @return string
     */
    protected function getKey($key)
    {
        return $this->namespace . $this->getTagsKey() . '-' . $key;
    }

    /**
     * Returns
     *
     * @return string
     */
    public function getTagsKey()
    {
        return implode('-', $this->tags) . '-' . md5(implode('-', $this->getTagValues()));
    }

    /**
     * Returns
     *
     * @return array
     */
    protected function getTagValues()
    {
        // Step1 Get tag
        $keys = array_map(array($this, 'getTagKey'), $this->tags);
        $values = $this->cache->getMulti($keys);

        // Step2 Init new tag value
        $emptyKeys = array_diff($values, array_filter($values));
        if ($emptyKeys) {
            $newValues = $this->setTagValues($emptyKeys);
            $values = array_merge($values, $newValues);
        }

        return $values;
    }

    /**
     * Init tag value by cache keys
     *
     * @param array $keys
     * @return array
     */
    protected function setTagValues($keys)
    {
        $values = array();
        foreach ($keys as $key => $value) {
            $values[$key] = $this->generateTagValue();
        }
        $this->cache->setMulti($values);
        return $values;
    }

    /**
     * Return the cache key of tag
     *
     * @param string $name
     * @return string
     */
    public function getTagKey($name)
    {
        return $this->namespace . 'tag-' . $name;
    }

    /**
     * Generate a new tag value
     *
     * @return string
     */
    protected function generateTagValue()
    {
        return strtr(uniqid('', true), array('.' => ''));
    }
}