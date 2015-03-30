<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/26/15
 * Time: 9:51 PM
 */

namespace Incraigulous\ContentfulSDK;

use Incraigulous\ContentfulSDK\ManagementResources\Assets;
use Incraigulous\ContentfulSDK\ManagementResources\ContentTypes;
use Incraigulous\ContentfulSDK\ManagementResources\Entries;
use Incraigulous\ContentfulSDK\ManagementResources\Spaces;
use Incraigulous\ContentfulSDK\ManagementResources\Webhooks;

/**
 * Factory for returning resources.
 *
 * Class ManagementSDK
 * @package Incraigulous\ContentfulSDK
 */

class ManagementSDK extends SDKBase {

    /**
     * Use the assets resource.
     * @return \Incraigulous\ContentfulSDK\ManagementResources\Assets
     */
    function assets()
    {
        return new Assets($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the content_types resource.
     * @return \Incraigulous\ContentfulSDK\ManagementResources\ContentTypes
     */
    function contentTypes()
    {
        return new ContentTypes($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the entries resource.
     * @return \Incraigulous\ContentfulSDK\ManagementResources\Entries
     */
    function entries()
    {
        return new Entries($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the spaces resource.
     * @return \Incraigulous\ContentfulSDK\ManagementResources\Spaces
     */
    function spaces()
    {
        return new Spaces($this->spaceId, $this->accessToken, $this->cacher);
    }

    /**
     * Use the spaces resource.
     * @return \Incraigulous\ContentfulSDK\ManagementResources\Webhooks
     */
    function webhooks()
    {
        return new Webhooks($this->spaceId, $this->accessToken, $this->cacher);
    }
}