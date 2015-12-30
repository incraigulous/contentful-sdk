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

    protected $preview;

    function __construct($accessToken, $spaceId = null, CacherInterface $cacher = null, $preview = FALSE)
    {
      parent::__construct($accessToken, $spaceId, $cacher);
      $this->preview = $preview;
    }

    /**
     * Use the assets resource.
     * @return \Incraigulous\ContentfulSDK\Resources\Assets
     */
    function assets()
    {
        return new Assets($this->accessToken, $this->spaceId, $this->cacher, $this->preview);
    }

    /**
     * Use the content_types resource.
     * @return \Incraigulous\ContentfulSDK\Resources\ContentTypes
     */
    function contentTypes()
    {
        return new ContentTypes($this->accessToken, $this->spaceId, $this->cacher, $this->preview);
    }

    /**
     * Use the entries resource.
     * @return Entries
     */
    function entries()
    {
        return new Entries($this->accessToken, $this->spaceId, $this->cacher, $this->preview);
    }

    /**
     * Use the spaces resource.
     * @return \Incraigulous\ContentfulSDK\Resources\Spaces
     */
    function spaces()
    {
        return new Spaces($this->accessToken, $this->spaceId, $this->cacher, $this->preview);
    }

}
