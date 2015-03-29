<?php
namespace Incraigulous\ContentfulSDK;

use GuzzleHttp;

class ManagementClient extends ClientBase {
    protected $endpointBase = 'https://api.contentful.com/spaces/';

    /**
     * Get the content type for post/put requests.
     * @return string
     */
    function getContentType()
    {
        return "application/vnd.contentful.management.v1+json";
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
        $result = $this->client->get($url, [
            'headers' => array_merge([
                'Authorization' => $this->getBearer()
            ], $headers)
        ])->json();
        return $result;
    }

    /**
     * Build and make a POST request.
     * @param $resource
     * @param array $payload
     * @param array $headers
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function post($resource, $payload = array(), $headers = array())
    {
        $result = $this->client->post($this->build_url($resource), [
            'headers' => array_merge([
                'Content-Type' => $this->getContentType(),
                'Authorization' => $this->getBearer(),
                'Content-Length' => (!count($payload)) ? 0 : strlen(json_encode($payload)),
            ], $headers),
            'body' => json_encode($payload)
        ]);
        return $result;
    }

    /**
     * Build and make a PUT request.
     * @param $resource
     * @param array $payload
     * @param array $headers
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function put($resource, $payload = array(), $headers = array())
    {
        $result = $this->client->put($this->build_url($resource), [
            'headers' => array_merge([
                'Content-Type' => $this->getContentType(),
                'Authorization' => $this->getBearer(),
                'Content-Length' => (!count($payload)) ? 0 : strlen(json_encode($payload)),
            ], $headers),
            'body' => json_encode($payload)
        ]);

        return $result;
    }

    /**
     * Build and make a DELETE request.
     * @param $resource
     * @param array $headers
     * @return GuzzleHttp\Message\FutureResponse|GuzzleHttp\Message\ResponseInterface|GuzzleHttp\Ring\Future\FutureInterface|mixed|null
     */
    function delete($resource, $headers = array())
    {
        $result = $this->client->delete($this->build_url($resource), [
            'headers' => array_merge([
                'Authorization' => $this->getBearer()
            ], $headers)
        ]);
        return $result;
    }
}