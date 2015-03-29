<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class Entry implements PayloadBuilderInterface {
    protected $fields;

    function __construct($fields)
    {
        $this->fields = $this->objectifyFields($fields);
    }

    /**
     * If the field is an array, convert it to an object to get the language formatting.
     *
     * @param $fields
     * @return array
     */
    function objectifyFields($fields) {
        $new = array();
        foreach($fields as $name => $field) {
            if (is_object($field) && !array($field)) {
                $new[] = $field;
            } else {
                $new[] = new Field($name, $field);
            }
        }
        return $new;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return ['fields' => $this->fields];
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        //No key used.
    }
}