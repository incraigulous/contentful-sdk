<?php
namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\DeliverySDK;
use Incraigulous\ContentfulSDK\ManagementSDK;
use PHPUnit_Framework_TestCase;

class FactoryTests extends PHPUnit_Framework_TestCase
{
    function testAssetsReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->assets()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testAssetsReturnsResource()
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->assets();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\Resources\Assets', $resource);
    }

    function testEntriesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->entries()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testEntriesReturnsResource()
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->entries();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\Resources\Entries', $resource);
    }

    function testSpacesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->spaces()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testSpacesReturnsResource()
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->spaces();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\Resources\Spaces', $resource);
    }

    function testContentTypesReturnsClient()
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->contentTypes()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\DeliveryClient', $client);
    }

    function testContentTypesReturnsResource()
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->contentTypes();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\Resources\ContentTypes', $resource);
    }

    function testManagementAssetsReturnsClient()
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->assets()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementClient', $client);
    }

    function testManagementAssetsReturnsResource()
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->assets();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementResources\Assets', $resource);
    }

    function testManagementEntriesReturnsClient()
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->entries()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementClient', $client);
    }

    function testManagementEntriesReturnsResource()
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->entries();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementResources\Entries', $resource);
    }

    function testManagementSpacesReturnsClient()
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->spaces()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementClient', $client);
    }

    function testManagementSpacesReturnsResource()
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->spaces();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementResources\Spaces', $resource);
    }

    function testManagementContentTypesReturnsClient()
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->contentTypes()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementClient', $client);
    }

    function testManagementContentTypesReturnsResource()
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->contentTypes();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementResources\ContentTypes', $resource);
    }

    function testManagementWebhooksReturnsClient()
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->webhooks()->client();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementClient', $client);
    }

    function testManagementWebhooksReturnsResource()
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->webhooks();
        $this->assertInstanceOf('Incraigulous\ContentfulSDK\ManagementResources\Webhooks', $resource);
    }
}