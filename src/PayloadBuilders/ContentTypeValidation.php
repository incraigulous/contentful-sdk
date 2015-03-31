<?php
namespace Incraigulous\ContentfulSDK\PayloadBuilders;

class ContentTypeValidation implements PayloadBuilderInterface {
    protected $data;

    /**
     * Validates that the size of a text, object or array is within a range.
     * @param null $min
     * @param null $max
     * @return $this
     */
    function size($min = null, $max = null) {
        $size = [];
        if ($min) $size['min'] = $min;
        if ($max) $size['max'] = $max;
        if (count($size)) $this->data['size'] = $size;
        return $this;
    }

    /**
     * Validates that the value of a field belongs to a predefined set. It's defined specifying the elements that form the valid set.
     * @param array $set
     * @return $this
     */
    function in(array $set) {
        $this->data['in'] = $set;
        return $this;
    }

    /**
     * Validates that the value of a field matches a Regular Expression.
     * @param $pattern
     * @param null $flags
     * @return $this
     */
    function regexp($pattern, $flags = null) {
        $regexp['pattern'] = $pattern;
        if ($flags) $regexp['flags'] = $flags;
        $this->data['regexp'] = $regexp;
        return $this;
    }

    /**
     * Validates that the value of a field is within a range. It's defined specifying the min and max values of that range.
     * @param null $min
     * @param null $max
     * @return $this
     */
    function dateRange($min = null, $max = null) {
        $range = [];
        if ($min) $range['min'] = $min;
        if ($max) $range['max'] = $max;
        if (count($range)) $this->data['dateRange'] = $range;
        return $this;
    }

    /**
     * Validates that the size of an asset is within a range. It's defined specifying the min and max values of that range. min and max are inclusive.
     * @param null $min
     * @param null $max
     * @return $this
     */
    function assetFileSize($min = null, $max = null) {
        $range = [];
        if ($min) $range['min'] = $min;
        if ($max) $range['max'] = $max;
        if (count($range)) $this->data['assetFileSize'] = $range;
        return $this;
    }

    /**
     * Validates that the dimensions of an image are within a range.
     * @param null $height
     * @param null $width
     * @return $this
     */
    function assetImageDimensions($height = null, $width = null) {
        $imageDimensions = [];
        if ($height) $imageDimensions['height'] = $height;
        if ($width) $imageDimensions['width'] = $width;
        if (count($imageDimensions)) $this->data['assetImageDimensions'] = $imageDimensions;
        return $this;
    }
    /**
     * Return the payload builder array part.
     * @return array
     */
    function make()
    {
        $result = [];
        foreach($this->data as $key => $data) {
            $result[] = [$key => $data];
        }
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