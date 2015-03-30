<?php

namespace Incraigulous\ContentfulSDK\Resources;

use Incraigulous\ContentfulSDK\RequestDecorator;

abstract class ResourceBase {
    protected $clientClassName = 'Incraigulous\ContentfulSDK\DeliveryClient';
    protected $resourceName;
    protected $spaceId;
    protected $accessToken;
    protected $client;
    protected $requestDecorator;
    protected $cacher;

    function __construct($spaceId, $accessToken, CacherInterface $cacher = null)
    {
        $this->spaceId = $spaceId;
        $this->accessToken = $accessToken;
        $this->cacher;
        $this->refresh();
    }

    /**
     * Init and store a new client and decorator.
     */
    function refresh() {
        $this->client = new $this->clientClassName($this->spaceId, $this->accessToken, $this->cacher);
        $this->requestDecorator = new RequestDecorator();
        $this->requestDecorator->setResource($this->resourceName);
    }

    /**
     * Limits results by ID.
     * @param $id
     * @return $this
     */
    function find($id)
    {
        $this->requestDecorator->setId($id);
        return $this;
    }

    /**
     * Limit results by operator serach.
     * @param $field
     * @param $operator
     * @param $value
     * @return $this
     */
    function where($field, $operator, $value)
    {
        switch ($operator) {
            //EQUALITY
            case '=':
                $this->requestDecorator->addParameter($field, '=', $value);
                break;
            //INEQUALITY
            case '!=':
            case '[ne]':
            case 'ne':
                $this->requestDecorator->addParameter($field, '[ne]', $value);
                break;
            //INCLUSION
            case '[in]':
            case 'in':
                $this->requestDecorator->addParameter($field, '[in]', $value);
                break;
            //EXCLUSION
            case '[nin]':
            case 'nin':
                $this->requestDecorator->addParameter($field, '[nin]', $value);
                break;
            //LESS THAN
            case '<':
            case '[lt]':
            case 'lt':
                $this->requestDecorator->addParameter($field, '[lt]', $value);
                break;
            //GREATER THAN
            case '>':
            case '[gt]':
            case 'gt':
                $this->requestDecorator->addParameter($field, '[gt]', $value);
                break;
            //LESS THAN OR EQUAL TO
            case '<=':
            case '[lte]':
            case 'lte':
                $this->requestDecorator->addParameter($field, '[lte]', $value);
                break;
            //GREATER THAN OR EQUAL TO
            case '>=':
            case '[gte]':
            case 'gte':
                $this->requestDecorator->addParameter($field, '[gte]', $value);
                break;
            //MATCH
            case 'match':
            case '[match]':
                $this->requestDecorator->addParameter($field, '[match]', $value);
                break;
            //LOCATION - NEAR
            case 'near':
            case '[near]':
                $this->requestDecorator->addParameter($field, '[near]', $value);
                break;
            //LOCATION - WITHIN
            case 'within':
            case '[within]':
                $this->requestDecorator->addParameter($field, '[within]', $value);
                break;
            default:
                $this->requestDecorator->addParameter($field, $operator, $value);
        }
        return $this;
    }

    /**
     * Alias for $this->query();
     * @param $search
     * @return $this
     */
    function full($search)
    {
        $this->query($search);
        return $this;
    }

    /**
     * Search all records for text match.
     * @param $search
     * @return $this
     */
    function query($search)
    {
        $this->requestDecorator->addParameter('query', '=', $search);
        return $this;
    }

    /**
     * Order results by a field.
     * @param $orderBy
     * @param bool $reverse
     * @return $this
     */
    function order($orderBy, $reverse = false)
    {
        $this->requestDecorator->addParameter('order', ($reverse) ? "=" : "=-", $reverse);
        return $this;
    }

    /**
     * Limit results by a quantity.
     * @param $number
     * @return $this
     */
    function limit($number)
    {
        $this->requestDecorator->addParameter('limit', '=', $number);
        return $this;
    }

    /**
     * Skip a quantity of results.
     * @param $number
     * @return $this
     */
    function skip($number)
    {
        $this->requestDecorator->addParameter('skip', '=', $number);
        return $this;
    }

    /**
     * Make a GET request.
     * @return mixed
     */
    function get()
    {
        $result = $this->client->get($this->requestDecorator->makeResource(), $this->requestDecorator->makeQuery());
        $this->refresh();
        return $result;
    }

    /**
     * Return the client.
     * @return mixed
     */
    function client()
    {
        return $this->client();
    }
}