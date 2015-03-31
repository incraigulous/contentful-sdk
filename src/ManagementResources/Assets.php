<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


class Assets extends ResourceBase {
    use IsPublishable;
    use IsArchivable;

    protected $resourceName = 'assets';

    /**
     * Process an asset.
     * @param $id
     * @param string $language
     * @return mixed
     */
    function process($id, $language = 'en-US')
    {
        $this->requestDecorator->setId($id  . '/files/' . $language . '/process');
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

}