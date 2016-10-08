<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


class Entries extends ResourceBase {
    use IsPublishable;
    use IsArchivable;

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
     * Target locale
     * @param $locale
     * @return $this
     */
    function limitByLocale($locale)
    {
        $this->requestDecorator->addParameter('locale', '=', $locale);
        return $this;
    }

    /**
     * Target content type.
     * @param $contentType
     * @return $this
     */
    function contentType($contentType)
    {
        $this->requestDecorator->addHeader('X-Contentful-Content-Type', $contentType);
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