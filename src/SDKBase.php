<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/27/15
 * Time: 10:36 AM
 */

namespace Incraigulous\ContentfulSDK;

abstract class SDKBase {
    protected $spaceId;
    protected $accessToken;
    protected $cacher;

    function __construct($spaceId, $accessToken, CacherInterface $cacher = null)
    {
        $this->spaceId = $spaceId;
        $this->accessToken = $accessToken;
        $this->cacher;
    }
}