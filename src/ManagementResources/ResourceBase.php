<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


abstract class ResourceBase extends \Incraigulous\ContentfulSDK\Resources\ResourceBase {
    protected $clientClassName = 'Incraigulous\ContentfulSDK\ManagementClient';

    /**
     * Make a post request.
     * @param $payload
     * @return mixed
     */
    function post($payload)
    {
        $this->requestDecorator->setPayload($payload);
        $result = $this->client->post($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Make a put request.
     * @param $id
     * @param $payload
     * @return mixed
     */
    function put($id, $payload)
    {
        $this->requestDecorator->setId($id);
        $this->requestDecorator->setPayload($payload);
        if ((is_array($payload)) && (!empty($payload['sys']['version']))) {
            $this->requestDecorator->addHeader('X-Contentful-Version', $payload['sys']['version']);
        }
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Make a delete request.
     * @param $id
     * @return mixed
     */
    function delete($id)
    {
        $this->requestDecorator->setId($id);
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }
}