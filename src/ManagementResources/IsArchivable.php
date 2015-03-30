<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


trait IsArchivable {

    /**
     * Archive a record.
     * @param $id
     * @return mixed
     */
    function archive($id)
    {
        $this->requestDecorator->setId($id  . '/archived');
        $result = $this->client->put($this->requestDecorator->makeResource(), $this->requestDecorator->makePayload(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

    /**
     * Unarchive a record.
     * @param $id
     * @return mixed
     */
    function unarchive($id)
    {
        $this->requestDecorator->setId($id  . '/archived');
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }
}