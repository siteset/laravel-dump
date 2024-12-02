<?php

namespace Siteset\Dump\Database;

class Field
{
    /**
     * Field Name
     * 
     * @var string
     */
    
    public $name;
    
    /**
     * Constructor
     * 
     * @param string $name
     */
    
    public function __construct($name)
    {
        $this->name  = $name;
    }
}
