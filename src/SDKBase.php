<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/27/15
 * Time: 10:36 AM
 */

namespace Incraigulous\ContentfulSDK;

abstract class SDKBase {
    protected $accessToken;
    protected $spaceId;
    protected $cacher;

    function __construct($accessToken, $spaceId = null, CacherInterface $cacher = null)
    {
        $this->accessToken = $accessToken;
        $this->spaceId = $spaceId;
        $this->cacher = $cacher;
    }
}