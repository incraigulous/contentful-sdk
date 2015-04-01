<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


trait IsPublishable {

    /**
     * Publish a record.
     * @param $id
     * @param $previous
     * @return mixed
     */
    function publish($id, $previous)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previous['sys']['version']);
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Unublish a record.
     * @param $id
     * @param $previous
     * @return mixed
     */
    function unpublish($id, $previous)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previous['sys']['version']);
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }
}