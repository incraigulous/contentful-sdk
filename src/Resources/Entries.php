<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/29/15
 * Time: 8:12 PM
 */

namespace Incraigulous\ContentfulSDK\Resources;


class Entries extends ResourceBase {
    protected $resourceName = 'entries';

    /**
     * Alias for $this->contentType()
     * @param $contentType
     * @return $this
     */
    function limitByType($contentType)
    {
        $this->contentType($contentType);
        return $this;
    }

    /**
     * Target content type.
     * @param $contentType
     * @return $this
     */
    function contentType($contentType)
    {
        $this->requestDecorator->addParameter('content_type', '=', $contentType);
        return $this;
    }

    /**
     * Include a set number of association/join/relationship levels.
     * @param $levels
     * @return $this
     */
    function includeLinks($levels)
    {
        $this->requestDecorator->addParameter('include', '=', $levels);
        return $this;
    }
}