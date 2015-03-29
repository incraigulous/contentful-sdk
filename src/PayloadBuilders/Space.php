<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class Space implements PayloadBuilderInterface {
    protected $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return ['name' => $this->name];
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        //No key used.
    }
}