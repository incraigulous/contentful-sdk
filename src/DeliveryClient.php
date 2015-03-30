<?php
namespace Incraigulous\ContentfulSDK;

use GuzzleHttp;
use Incraigulous\Contentful\ClientInterface;

class DeliveryClient extends ClientBase {
    protected $endpointBase = 'https://cdn.contentful.com/spaces/';

}