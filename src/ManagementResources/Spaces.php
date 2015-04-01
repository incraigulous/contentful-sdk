<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;

use Incraigulous\ContentfulSDK\RequestDecorator;

class Spaces extends ResourceBase {
    protected $resourceName = null;

    /**
     * Init and store a new client and decorator.
     */
    function refresh() {
        $this->client = new $this->clientClassName($this->accessToken, null, $this->cacher);
        $this->requestDecorator = new RequestDecorator();
        $this->requestDecorator->setResource($this->resourceName);
    }

}