<?php

/**
 * Widget Framework
 *
 * @copyright   Copyright (c) 2008-2012 Twin Huang
 * @license     http://www.opensource.org/licenses/apache2.0.php Apache License
 */

namespace Widget;

/**
 * Event
 *
 * @package     Widget
 * @author      Twin Huang <twinh@yahoo.cn>
 * @link        http://api.jquery.com/category/events/event-object/
 */
class Event extends WidgetProvider
{
    /**
     * The name of event
     *
     * @var string
     */
    protected $type;

    /**
     * Time stamp with microseconds when object constructed
     *
     * @var float
     */
    protected $timeStamp;
    
    /**
     * Whether prevent the default action or not
     * 
     * @var bool
     */
    protected $preventDefault = false;
    
    /**
     * Whether top triggering the next handler or nots
     * 
     * @var bool
     */
    protected $stopPropagation = false;

    /**
     * The last value returned by an event handler
     * 
     * @var mixed
     */
    protected $result;
    
    /**
     * The data accepted from the handler
     * 
     * @var array 
     */
    protected $data = array();
    
    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct(array $options = array())
    {
        $this->timeStamp = microtime(true);
        
        parent::__construct($options);
    }

    /**
     * Create a new event
     *
     * @return mixed
     */
    public function __invoke($type)
    {
        return new static(array(
            'widget'    => $this->widget,
            'type'      => $type
        ));
    }
    
    /**
     * Get the type of event
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of event
     *
     * @param  string      $type
     * @return \Widget\Event
     */
    public function setType($type)
    {
        $this->type = strtolower($type);

        return $this;
    }

    /**
     * Get the time stamp
     *
     * @return string
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }
    
    /**
     * @return \Widget\Event
     */
    public function preventDefault()
    {
        $this->preventDefault = true;
        
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefaultPrevented()
    {
        return $this->preventDefault;
    }
    
    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
        
        return $this;
    }
    
    /**
     * @param mixed $data
     */
    public function setData($data = array())
    {
        $this->data = $data;
        
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @return \Widget\Event
     */
    public function stopPropagation()
    {
        $this->stopPropagation = true;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->stopPropagation;
    }
}
