<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class Entry implements PayloadBuilderInterface {
    protected $fields;

    function __construct($fields = null)
    {
        $this->fields = $this->objectifyFields($fields);
    }

    /**
     * Convert the field to an object to get the language formatting.
     *
     * @param $fields
     * @return array
     */
    protected function objectifyFields($fields) {
        $new = array();
        foreach($fields as $name => $field) {
            if (is_object($field)) {
                $new[] = $field;
            } else {
                $new[] = new EntryField($name, $field);
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
