<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/27/15
 * Time: 10:36 AM
 */

namespace Incraigulous\ContentfulSDK;

abstract class SDKBase {
    protected $clientClassName = 'Incraigulous\ContentfulSDK\DeliveryClient';

    protected $accessToken;
    protected $spaceId;
    protected $cacher;
    protected $client;

    function __construct($accessToken, $spaceId = null, CacherInterface $cacher = null, $assoc = true)
    {
        $this->accessToken = $accessToken;
        $this->spaceId = $spaceId;
        $this->cacher = $cacher;
        $this->client = new $this->clientClassName($this->accessToken, $this->spaceId, $this->cacher, $assoc);
    }
}