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
    function process($id, $language = null)
    {
        if (!$language && defined('CONTENTFUL_DEFAULT_LANGUAGE')) {
            $language = CONTENTFUL_DEFAULT_LANGUAGE;
        } else {
            $language = 'en-US';
        }
        $this->requestDecorator->setId($id  . '/files/' . $language . '/process');
        $result = $this->client->delete($this->requestDecorator->makeResource(), $this->requestDecorator->makeHeaders());
        $this->refresh();
        return $result;
    }

}