<?php

require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/Escape.php';

/**
 * Test class for Qwin_Escape.
 * Generated by PHPUnit on 2012-01-18 at 09:11:04.
 */
class Qwin_EscapeTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Escape
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_Escape;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_Escape::__invoke
     */
    public function test__invoke() {
        $widget = $this->object;

        $this->assertEquals('\\\\', $widget->escape('\\'));

        $this->assertEquals('\0', $widget->escape("\0"));

        $this->assertEquals('\\n', $widget->escape("\n"));

        $this->assertEquals('\r', $widget->escape("\r"));

        $this->assertEquals("\'", $widget->escape("'"));

        $this->assertEquals('\"', $widget->escape('"'));

        $this->assertEquals('\Z', $widget->escape("\x1a"));
    }
}
