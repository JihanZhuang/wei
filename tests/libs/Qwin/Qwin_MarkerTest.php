<?php
require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/Marker.php';

/**
 * Test class for Qwin_Marker.
 * Generated by PHPUnit on 2012-01-18 at 09:09:15.
 */
class Qwin_MarkerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_Marker
     */
    protected $object;

    /**
     *
     * @var callback
     */
    protected $_display;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = Qwin::getInstance()->marker;

        // disable cusomer display callback
        $this->_display = $this->object->options['display'];
        $this->object->options['display'] = null;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        $this->object->options['display'] = $this->_display;
    }

    /**
     * @covers Qwin_Marker::__invoke
     * @covers Qwin_Marker::__construct
     * @covers Qwin_Marker::getMarkers
     */
    public function test__invoke() {
        $widget = $this->object;

        $widget->marker('Testing');

        $data = $widget->getMarkers();

        $this->assertArrayHasKey('Testing', $data);
    }

    /**
     * @covers Qwin_Marker::display
     */
    public function testDisplay() {
        $widget = $this->object;

        // test output records
        $result = $widget->display(false);

        $data = $widget->getMarkers();

        $this->assertCount(1 + count($data) + 1, explode('<tr>', $result), '1 + count($data) + 1(explode) rows');

        // test output directly
        ob_start();

        $result = $widget->display();

        ob_end_clean();

        $this->assertInstanceOf('Qwin_Widget', $result, 'return invoker instead');

        // test cutome display
        $widget->options['display'] = 'function($data){return count($data);}';

        $this->assertEquals($widget->display(false), count($widget->getMarkers()), 'custome callback function for dispaly that returns makers length');
    }
}
