<?php
ob_start();
require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/Error.php';

/**
 * Test class for Qwin_Error.
 * Generated by PHPUnit on 2012-02-02 at 02:33:36.
 */
class Qwin_ErrorTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Error
     */
    protected $object;

    /**
     * Is $_GET empty
     *
     * @var bool
     */
    protected $_emptyGet = false;

    protected $_emptyPost = false;

    protected $_emptyCookie = false;

    protected $_emptySession = false;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    /**
     * @covers Qwin_Session::start
     * @covers Qwin_Session::__construct
     */
    protected function setUp() {
        $q = Qwin::getInstance();

        $this->object = $q->error;

        // avoid error output by error widget
        restore_exception_handler();
        restore_error_handler();

        $this->object->config('debug', true);

        // construct fake data
        if (empty($_GET)) {
            $this->_emptyGet = true;
            $_GET = array(
                'key1' => '<a href="#">click me</a>value1',
                'key2' => 'value2',
                'key3' => array('value3'),
            );
        }
        if (empty($_POST)) {
            $this->_emptyPost = true;
            $_POST = array(
                'key1' => '<a href="#">click me</a>value1',
                'key2' => 'value2',
                'key3' => array('value3'),
            );
        }
        if (empty($_COOKIE)) {
            $this->_emptyCookie = true;
            $_COOKIE = array(
                'key1' => '<a href="#">click me</a>value1',
                'key2' => 'value2',
            );
        }
        if (empty($_SESSION)) {
            $this->object->session;

            $this->_emptySession = true;
            $_SESSION = array(
                'key1' => '<a href="#">click me</a>value1',
                'key2' => 'value2',
                'key3' => array('value3'),
            );
        }
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        if ($this->_emptyGet) {
            $_GET = array();
        }

        if ($this->_emptyPost) {
            $_POST = array();
        }

        if ($this->_emptyCookie) {
            $_COOKIE = array();
        }

        if ($this->_emptySession) {
            $_SESSION = array();
        }
    }

    /**
     * @covers Qwin_Error::__invoke
     * @covers Qwin_Error::__construct
     * @covers Qwin_Log::__construct
     */
    public function test__invoke() {
        $widget = $this->object;

        // close exit option
        $widget->option('exit', false);

        // fixed key not defined in cli mode
        !isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] = null;

        !isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] = null;

        // test string param
        ob_start();

        $widget->error('Error test');

        $output = ob_get_contents();
        $output && ob_end_clean();


        // test array param
        ob_start();

        $widget->error(array(
            'code' => 500,
            'message' => 'Error test',
        ));

        $output = ob_get_contents();
        $output && ob_end_clean();

        // test exception obejct param
        ob_start();

        $widget->error(new Exception('Error test', 500), array());

        $output = ob_get_contents();
        $output && ob_end_clean();
    }

    /**
     * @covers Qwin_Error::renderError
     */
    public function testRenderError() {
        $widget = $this->object;

        $this->setExpectedException('ErrorException');

        $widget->renderError(E_STRICT, 'Error test', __FILE__, __LINE__);
    }

    /**
     * @covers Qwin_Error::getFileCode
     */
    public function testGetFileCode() {
        $widget = $this->object;

        $widget->getFileCode(__FILE__, 1, 10);
    }

    /**
     * @covers Qwin_Error::getTraceString
     */
    public function testGetTraceString() {
        $widget = $this->object;

        $traces = debug_backtrace();

        // add fake data for full test
        $traces[] = array(
            'file' => __FILE__,
            'type' => '->',
            'function' => __FUNCTION__,
            'class' => __CLASS__,
            'args' => array(
                new Qwin_Widget,
                'string',
                true,
                false,
                array('key' => 'value'),
            ),
        );

        $traces[] = array(
            'function' => __FUNCTION__,
            'args' => array(),
        );

        $widget->getTraceString($traces);
    }

    /**
     * @covers Qwin_Error::getServer
     */
    public function testGetServer() {
        $widget = $this->object;

        if (!isset($_SERVER['QUERY_STRING'])) {
            $_SERVER['QUERY_STRING'] = '?' . time();
        }

        if (!isset($_SERVER['PATH'])) {
            $_SERVER['PATH'] = 'dir1' . PATH_SEPARATOR . 'dir2';
        }

        $server = $widget->getServer();

        $this->assertCount(count($_SERVER), $server);
    }

    /**
     * @covers Qwin_Error::getGet
     */
    public function testGetGet() {
        $widget = $this->object;

        $get = $widget->getGet();

        $this->assertCount(count($_GET), $get);
    }

    /**
     * @covers Qwin_Error::getPost
     */
    public function testGetPost() {
        $widget = $this->object;

        $post = $widget->getPost();

        $this->assertCount(count($_POST), $post);
    }

    /**
     * @covers Qwin_Error::getCookie
     */
    public function testGetCookie() {
        $widget = $this->object;

        $cookie = $widget->getCookie();

        $this->assertCount(count($_COOKIE), $cookie);
    }

    /**
     * @covers Qwin_Error::getSession
     * @covers Qwin_Session::start
     */
    public function testGetSession() {
        $widget = $this->object;

        $session = $widget->getSession();

        $this->assertCount(count($_SESSION), $session);

        $temp = $widget->session;
        $widget->session = false;

        $this->assertInternalType('string', $widget->getSession());

        $widget->session = $temp;
    }
}
