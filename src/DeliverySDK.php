<?php

namespace Incraigulous\ContentfulSDK;

use Incraigulous\ContentfulSDK\Resources\Spaces;
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
        return new Assets($this->client);
    }

    /**
     * Use the content_types resource.
     * @return \Incraigulous\ContentfulSDK\Resources\ContentTypes
     */
    function contentTypes()
    {
        return new ContentTypes($this->client);
    }

    /**
     * Use the entries resource.
     * @return Entries
     */
    function entries()
    {
        return new Entries($this->client);
    }

    /**
     * Use the spaces resource.
     * @return \Incraigulous\ContentfulSDK\Resources\Spaces
     */
    function spaces()
    {
        return new Spaces($this->client);
    }

}