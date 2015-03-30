<?php
namespace Incraigulous\ContentfulSDK;

use GuzzleHttp;

abstract class ClientBase {
    protected $client;
    private $spaceId;
    private $accessToken;
    protected $endpointBase;
    protected $cacher;

    function __construct($spaceId, $accessToken, CacherInterface $cacher = null) {
        $this->spaceId = $spaceId;
        $this->accessToken = $accessToken;
        $this->client = new GuzzleHttp\Client();
        $this->cacher = $cacher;
    }

    /**
     * Get the Guzzle Client.
     * @return GuzzleHttp\Client
     */
    function getClient() {
        return $this->client;
    }

    /**
     * Format the authorization header.
     * @return string
     */
    function getBearer() {
        return ' Bearer ' . $this->accessToken;
    }

    /**
     * Get the endpoint.
     * @return string
     */
    function getEndpoint() {
        return $this->endpointBase . $this->spaceId;
    }

    /**
     * Make a get request.
     * @param $resource
     * @param array $query
     * @param array $headers
     * @return mixed
     */
    function get($resource, $query = array(), $headers = array()) {
        $url = $this->build_url($resource, $query);
        $key = $this->buildCacheKey('get', $resource, $url, $headers, $query);
        if (($this->cacher) && ($this->cacher->has($key))) return $this->cacher->get($key);
        $result = $this->client->get($url, [
            'headers' => array_merge([
                'Authorization' => $this->getBearer()
            ], $headers)
        ])->json();
        if ($this->cacher) $this->cacher->put($key, $result);
        return $result;
    }

    /**
     * Build the query URL.
     * @param $resource
     * @param $query
     * @return string
     */
    function build_url($resource, array $query = array()) {
        $url = $this->getEndpoint();
        if ($resource) $url .= '/' . $resource;
        if (!empty($query)) $url .= '?' . http_build_query($query);
        return $url;
    }

    /**
     * Return a unique key for the query.
     * @param $method
     * @param $resource
     * @param $url
     * @param array $query
     * @param array $headers
     * @return string
     */
    function buildCacheKey($method, $resource, $url, $headers = array(), $query = array()) {
        return md5($method . $resource . $url . json_encode($query) . json_encode($headers));
    }
}