<?php
namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\DeliverySDK;
use PHPUnit_Framework_TestCase;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    function testAssetsReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->assets()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testEntriesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->entries()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testSpacesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->spaces()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testContentTypesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->contentTypes()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }
}