<?php

/**
 * Wei Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://opensource.org/licenses/mit-license.php MIT License
 */

namespace Wei;

/**
 * Generate a URL with signature
 *
 * @property \Wei\Request $request
 */
class SafeUrl extends Base
{
    /**
     * The token to generate the signature
     *
     * @var string
     */
    protected $token;

    /**
     * The expire seconds of signature
     *
     * @var int
     */
    protected $expireTime = 60;

    /**
     * Generate a URL with signature, alias of generate method
     *
     * @param string $url
     * @param array $keys
     * @return string
     */
    public function __invoke($url, $keys = array())
    {
        return $this->generate($url, $keys);
    }

    /**
     * Generate a URL with signature
     *
     * @param string $url
     * @param array $keys
     * @return string
     */
    public function generate($url, $keys = array())
    {
        $time = time();
        $query = parse_url($url, PHP_URL_QUERY);
        parse_str($query, $query);

        $query = $this->filterKeys($query, $keys);
        $query['timestamp'] = $time;

        $flag = $this->generateToken($query);

        return $url . '&timestamp=' . $time . '&flag=' . $flag;
    }

    /**
     * Verify whether the URL signature is OK
     *
     * @param array $keys
     * @return bool
     */
    public function verify($keys = array())
    {
        // Check if time is expired
        $time = $this->request->getQuery('timestamp');
        if ($this->expireTime && time() - $time > $this->expireTime) {
            return false;
        }

        // Remove flag parameters
        $query = $this->request->getParameterReference('get');
        $token = $this->request->getQuery('flag');
        unset($query['flag']);

        $timestamp = $query['timestamp'];

        $query = $this->filterKeys($query, $keys);

        $query['timestamp'] = $timestamp;


        if ($this->generateToken($query) == $token) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate signature by specified array
     *
     * @param array $array
     * @return string
     */
    protected function generateToken(array $array)
    {
        return md5(implode('|', $array) . $this->token);
    }

    /**
     * Removes array element by keys
     *
     * @param string $query
     * @param array $keys
     * @return array
     */
    protected function filterKeys($query, $keys)
    {
        return $keys ? array_intersect_key($query, array_flip((array)$keys)) : $query;
    }
}