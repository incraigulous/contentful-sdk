<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


trait IsPublishable {

    /**
     * Publish a record.
     * @param $id
     * @param $previousVersion
     * @return mixed
     */
    function publish($id, $previousVersion)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previousVersion);
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Unublish a record.
     * @param $id
     * @param $previousVersion
     * @return mixed
     */
    function unpublish($id, $previousVersion)
    {
        $this->requestDecorator->setId($id  . '/published');
        $this->requestDecorator->addHeader('X-Contentful-Version', $previousVersion);
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }
}