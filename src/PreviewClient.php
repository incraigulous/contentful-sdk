<?php
namespace Incraigulous\ContentfulSDK;

use GuzzleHttp;

class PreviewClient extends DeliveryClient {
    protected $endpointBase = 'https://preview.contentful.com/spaces';

}