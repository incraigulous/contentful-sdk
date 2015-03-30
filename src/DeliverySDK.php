<?php

namespace Incraigulous\ContentfulSDK;

use Incraigulous\ContentfulSDK\ManagementResources\Spaces;
use Incraigulous\ContentfulSDK\Resources\Assets;
use Incraigulous\ContentfulSDK\Resources\ContentTypes;
use Incraigulous\ContentfulSDK\Resources\Entries;

/**
 * Factory for returning resources.
 *
 * Class DeliverySDK
 * @package Incraigulous\ContentfulSDK
 */

class DeliverySDK extends SDKBase {

    /**
     * Use the assets resource.
     * @return \Incraigulous\ContentfulSDK\Resources\Assets
     */
    function assets()
    {
        return new Assets($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the content_types resource.
     * @return \Incraigulous\ContentfulSDK\Resources\ContentTypes
     */
    function contentTypes()
    {
        return new ContentTypes($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the entries resource.
     * @param null $contentType
     * @return Entries
     */
    function entries($contentType = null)
    {
        $entries = new Entries($this->spaceId, $this->accessToken, $this->cacher);
        if ($contentType) $entries->contentType($contentType);
        return $entries;
    }

    /**
     * Use the spaces resource.
     * @return \Incraigulous\ContentfulSDK\Resources\Spaces
     */
    function spaces()
    {
        return new Spaces($this->spaceId, $this->accessToken, $this->cacher);
    }

}