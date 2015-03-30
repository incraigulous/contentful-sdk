<?php

namespace Incraigulous\ContentfulSDK\ManagementResources;


class ContentTypes extends ResourceBase {
    use IsPublishable;
    use IsArchivable;

    protected $resourceName = 'content_types';

}