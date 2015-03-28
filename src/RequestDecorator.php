<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 10:21 PM
 */

namespace Incraigulous\ContentfulSDK;

use Incraigulous\ContentfulSDK\PayloadBuilders\PayloadBuilderInterface;

class RequestDecorator {
    protected $query;
    protected $resource;
    protected $payload;
    protected $id;
    protected $headers = array();

    function __construct(array $request = array())
    {
        $this->query = $request;
    }

    /**
     * Set the resource.
     * @param $resource
     */
    function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Set the request ID.
     * @param $id
     */
    function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Add a GET request query string paramater.
     * @param $field
     * @param $operator
     * @param $value
     */
    function addParameter($field, $operator, $value)
    {
        $this->query[] = [$field, $operator, $value];
    }

    /**
     * Add a request header.
     * @param $key
     * @param $value
     */
    function addHeader($key, $value) {
        $this->headers[$key] = $value;
    }

    /**
     * Set the payload. Can be a PayloadBuilder Object, an array, or an array with PayloadBuilder object parts.
     * @param $payload
     */
    function setPayload($payload)
    {
        $this->payload = $this->buildPayload($payload);
    }

    /**
     * Parse the payload to check for PayloadBuilder objects and make them.
     * @param $payload
     * @return array
     */
    function buildPayload(&$payload)
    {
        if (is_array($payload)) {
            $payload = $this->array_map_deep($payload, array($this, 'buildPayloadItem'));
        } else {
            $payload = $this->makePayloadBuilder($payload);
            $this->buildPayload($payload);
        }

        return $payload;
    }

    /**
     * Helper function: Applies the callback to each level of array.
     *
     * @param $array
     * @param $callback
     * @return array|mixed
     */
    function array_map_deep($array, $callback) {
        $new = array();
        if(is_array($array) ) foreach ($array as $key => $val) {
            if (is_array($val)) {
                $new[$key] = $this->array_map_deep($val, $callback);
            } else {
                $new[$key] = call_user_func($callback, $val);
            }
        }
        else $new = call_user_func($callback, $array);
        return $new;
    }

    /**
     * The array_map_deep callback for buildPayload. If the array part is an object, it attempts to make payloadBuilder.
     *
     * @param $item
     * @return mixed
     */
    function buildPayloadItem($item)
    {
        if (is_object($item)) {
            $item = $this->makePayloadBuilder($item);
        }
        return $item;
    }

    /**
     * Make a payloadBuilder object.
     * @param PayloadBuilderInterface $payloadBuilder
     * @return mixed
     */
    function makePayloadBuilder(PayloadBuilderInterface $payloadBuilder)
    {
        return $payloadBuilder->make();
    }

    /**
     * Return an array ready to be http encoded.
     * @return array
     */
    function makeQuery()
    {
        $query = array();
        foreach($this->query as $paramater) {
            $operator = ($paramater[1] != '=') ? $paramater[1] : '' ;
            $query[$paramater[0] . $operator] = $paramater[2];
        }
        return $query;
    }

    /**
     * Return the payload.
     * @return mixed
     */
    function makePayload() {
        return $this->payload;
    }

    /**
     * Return the headers array.
     * @return array
     */
    function makeHeaders() {
        return $this->headers;
    }

    /**
     * Return the resource url part.
     * @return string
     */
    function makeResource()
    {
        $resource = $this->resource;
        if ($this->id) $resource .= '/' . $this->id;
        return $resource;
    }
}