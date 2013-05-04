<?php
/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2013 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * A widget to detect user OS and browser name and version
 *
 * @author      Twin Huang <twinhuang@qq.com>
 * @property    Request $request A widget that handles the HTTP request data
 * 
 * @method      bool inIe() Check if the user is browsing in Internet Explorer browser
 * @method      bool inChrome() Check if the user is browsing in Chrome browser
 * @method      bool inFirefox() Check if the user is browsing in Firefox browser
 * 
 * @method      bool inIos()  Check if the device is running on Apple's iOS platform
 * @method      bool inAndroid() Check if the device is running on Google's Android platform
 * @method      bool inWindowsPhone() Check if the device is running on Windows Phone platform
 * 
 * @method      bool inIphone() Check if the user is browsing by iPhone/iPod
 * @method      bool inIpad() Check if the user is browsing by iPad
 */
class Os extends AbstractWidget
{
    protected $os = array(
        // Browser 
        'ie'            => 'MSIE ([\w.]+)',
        'chrome'        => 'Chrome\/([\w.]+)',
        'firefox'       => 'Firefox\/([\w.]+)',
        
        // OS
        'ios'           => 'iP(?:hone|ad).*OS ([\d_]+)', // Contains iPod
        'android'       => 'Android ([\w.]+)',
        'windowsphone'  => 'Windows Phone (?:OS )?([\w.]+)',
        
        // Device (Mobile & Tablet)
        'iphone'        => 'iPhone OS ([\d_]+)',
        'ipad'          => 'iPad.*OS ([\d_]+)'
    );

    /**
     * The versions of detected os
     * 
     * @var string
     */
    protected $versions = array();

    /**
     * The user agent string from request header
     * 
     * @var string
     */
    protected $ua;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);

        $this->ua = $this->request->getServer('HTTP_USER_AGENT');
    }

    /**
     * Check if in the specified browser, OS or device
     * 
     * @param string $os The name of browser, OS or device
     * @return bool
     */
    public function __invoke($os)
    {
        return $this->in($os);
    }

    /**
     * Check if in the specified browser, OS or device
     * 
     * @param string $os The name of browser, OS or device
     * @return bool
     */
    public function in($os)
    {
        $os = strtolower($os);
        if (isset($this->os[$os]) && preg_match('/' . $this->os[$os] . '/i', $this->ua, $matches)) {
            $this->versions[$os] = isset($matches[1]) ? $matches[1] : false;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns the version of specified browser, OS or device
     * 
     * @return string
     */
    public function getVersion($os)
    {
        $os = strtolower($os);
        if (!isset($this->versions[$os])) {
            $this->in($os);
        }
        return $this->versions[$os];
    }

    /**
     * Magic call for method inXXX
     * 
     * @param string $name
     * @param array $args
     * @return bool
     */
    public function __call($name, $args)
    {
        if('in' == substr($name, 0, 2)) {
            return $this->in(substr($name, 2));
        }
        return parent::__call($name, $args);
    }
    
    /**
     * Check if the device is mobile
     * 
     * @link https://github.com/serbanghita/Mobile-Detect
     * @license MIT License https://github.com/serbanghita/Mobile-Detect/blob/master/LICENSE.txt
     * @return bool
     */
    public function inMobile()
    {
        $s = $this->request->getParameterReference('server');
        
        if (
            isset($s['HTTP_ACCEPT']) &&
                (strpos($s['HTTP_ACCEPT'], 'application/x-obml2d') !== false || // Opera Mini; @reference: http://dev.opera.com/articles/view/opera-binary-markup-language/
                 strpos($s['HTTP_ACCEPT'], 'application/vnd.rim.html') !== false || // BlackBerry devices.
                 strpos($s['HTTP_ACCEPT'], 'text/vnd.wap.wml') !== false ||
                 strpos($s['HTTP_ACCEPT'], 'application/vnd.wap.xhtml+xml') !== false) ||
            isset($s['HTTP_X_WAP_PROFILE'])             || // @todo: validate
            isset($s['HTTP_X_WAP_CLIENTID'])            ||
            isset($s['HTTP_WAP_CONNECTION'])            ||
            isset($s['HTTP_PROFILE'])                   ||
            isset($s['HTTP_X_OPERAMINI_PHONE_UA'])      || // Reported by Nokia devices (eg. C3)
            isset($s['HTTP_X_NOKIA_IPADDRESS'])         ||
            isset($s['HTTP_X_NOKIA_GATEWAY_ID'])        ||
            isset($s['HTTP_X_ORANGE_ID'])               ||
            isset($s['HTTP_X_VODAFONE_3GPDPCONTEXT'])   ||
            isset($s['HTTP_X_HUAWEI_USERID'])           ||
            isset($s['HTTP_UA_OS'])                     || // Reported by Windows Smartphones.
            isset($s['HTTP_X_MOBILE_GATEWAY'])          || // Reported by Verizon, Vodafone proxy system.
            isset($s['HTTP_X_ATT_DEVICEID'])            || // Seend this on HTC Sensation. @ref: SensationXE_Beats_Z715e
            //HTTP_X_NETWORK_TYPE = WIFI
            ( isset($s['HTTP_UA_CPU']) &&
                    $s['HTTP_UA_CPU'] == 'ARM'          // Seen this on a HTC.
            )
        ) {
            return true;
        }
        return false;
    }
}
