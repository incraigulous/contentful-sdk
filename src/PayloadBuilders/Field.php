<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class Field implements PayloadBuilderInterface {
    protected $field;
    protected $content;
    protected $language;

    function __construct($field, $content, $language = 'en-US')
    {
        $this->field = $field;
        $this->content = $content;
        $this->language = $language;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        if (is_array($this->content)) return $this->content;
        return [$this->language => $this->content];
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        return $this->field;
    }
}