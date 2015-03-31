<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class Asset implements PayloadBuilderInterface {
    protected $fields;

    function __construct($fields = null, $file = null)
    {
        $this->fields = $this->objectifyFields($fields);
        $this->file = $this->objectifyFile($file);
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
                $new[] = new Field($name, $field);
            }
        }
        return $new;
    }

    /**
     * Convert the field to an object to get the language formatting.
     *
     * @param $fields
     * @return array
     */
    protected function objectifyFile($file) {
        if (is_object($file)) {
            return $file;
        } else {
            return new Field($file['contentType'], $file['fileName'], $file['upload'], $file['language']);
        }
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        return ['fields' => $this->fields, 'file' => $this->file];
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        //No key used.
    }
}