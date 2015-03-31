<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class ContentTypeField implements PayloadBuilderInterface {
    protected $id;
    protected $name;
    protected $type;
    protected $required;
    protected $localized;
    protected $validations;
    protected $linkType;
    protected $items;

    function __construct($id, $name, $type, $required = false, $localized = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->localized = $localized;
    }

    protected function makeValidations($validations)
    {
        if (is_array($validations)) {
            return $validations;
        } elseif (is_object($validations)) {
            return $validations->make();
        }
    }

    /**
     * Create a relationship.
     * @param string $linkType
     * @return $this
     */
    function setLink($linkType = 'Entry') {
        $this->type = 'Link';
        $this->linkType = $linkType;
        return $this;
    }

    /**
     * Add Validations.
     * @param $validations
     * @return $this
     */
    function setValidations($validations) {
        $this->validations = $this->makeValidations($validations);
        return $this;
    }

    /**
     * Create a relationship to multiple entries.
     * @param string $linkType
     * @return $this
     */
    function setMultiLink($linkType = 'Entry') {
        $this->type = 'Array';
        $this->items = [
            'type' => 'Link',
            'linkType' => $linkType
        ];
        return $this;
    }

    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        $result = [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type
        ];
        if ($this->linkType) $result['linkType'] = $this->linkType;
        if ($this->items) $result['items'] = $this->items;
        if ($this->required) $result['required'] = $this->required;
        if ($this->localized) $result['localized'] = $this->localized;
        if ($this->validations) $result['validations'] = $this->validations;
        return $result;
    }

    /**
     * Return the key.
     * @return mixed
     */
    function getKey() {
        //No key used.
    }
}