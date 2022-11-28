<?php
namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\DeliveryClient;
use Incraigulous\ContentfulSDK\DeliverySDK;
use Incraigulous\ContentfulSDK\ManagementClient;
use Incraigulous\ContentfulSDK\ManagementResources\Webhooks;
use Incraigulous\ContentfulSDK\ManagementSDK;
use Incraigulous\ContentfulSDK\Resources\Assets;
use Incraigulous\ContentfulSDK\Resources\ContentTypes;
use Incraigulous\ContentfulSDK\Resources\Entries;
use Incraigulous\ContentfulSDK\Resources\Spaces;
use PHPUnit\Framework\TestCase;

class FactoryTests extends TestCase
{
    public function testAssetsReturnsClient(): void
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->assets()->client();
        $this->assertInstanceOf(DeliveryClient::class, $client);
    }

    public function testAssetsReturnsResource(): void
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->assets();
        $this->assertInstanceOf(Assets::class, $resource);
    }

    public function testEntriesReturnsClient(): void
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->entries()->client();
        $this->assertInstanceOf(DeliveryClient::class, $client);
    }

    public function testEntriesReturnsResource(): void
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->entries();
        $this->assertInstanceOf(Entries::class, $resource);
    }

    public function testSpacesReturnsClient(): void
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->spaces()->client();
        $this->assertInstanceOf(DeliveryClient::class, $client);
    }

    public function testSpacesReturnsResource(): void
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->spaces();
        $this->assertInstanceOf(Spaces::class, $resource);
    }

    public function testContentTypesReturnsClient(): void
    {
        $client = (new DeliverySDK('asdf', 'asdf'))->contentTypes()->client();
        $this->assertInstanceOf(DeliveryClient::class, $client);
    }

    public function testContentTypesReturnsResource(): void
    {
        $resource = (new DeliverySDK('asdf', 'asdf'))->contentTypes();
        $this->assertInstanceOf(ContentTypes::class, $resource);
    }

    public function testManagementAssetsReturnsClient(): void
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->assets()->client();
        $this->assertInstanceOf(ManagementClient::class, $client);
    }

    public function testManagementAssetsReturnsResource(): void
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->assets();
        $this->assertInstanceOf(\Incraigulous\ContentfulSDK\ManagementResources\Assets::class, $resource);
    }

    public function testManagementEntriesReturnsClient(): void
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->entries()->client();
        $this->assertInstanceOf(ManagementClient::class, $client);
    }

    public function testManagementEntriesReturnsResource(): void
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->entries();
        $this->assertInstanceOf(\Incraigulous\ContentfulSDK\ManagementResources\Entries::class, $resource);
    }

    public function testManagementSpacesReturnsClient(): void
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->spaces()->client();
        $this->assertInstanceOf(ManagementClient::class, $client);
    }

    public function testManagementSpacesReturnsResource(): void
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->spaces();
        $this->assertInstanceOf(\Incraigulous\ContentfulSDK\ManagementResources\Spaces::class, $resource);
    }

    public function testManagementContentTypesReturnsClient(): void
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->contentTypes()->client();
        $this->assertInstanceOf(ManagementClient::class, $client);
    }

    public function testManagementContentTypesReturnsResource(): void
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->contentTypes();
        $this->assertInstanceOf(\Incraigulous\ContentfulSDK\ManagementResources\ContentTypes::class, $resource);
    }

    public function testManagementWebhooksReturnsClient(): void
    {
        $client = (new ManagementSDK('asdf', 'asdf'))->webhooks()->client();
        $this->assertInstanceOf(ManagementClient::class, $client);
    }

    public function testManagementWebhooksReturnsResource(): void
    {
        $resource = (new ManagementSDK('asdf', 'asdf'))->webhooks();
        $this->assertInstanceOf(Webhooks::class, $resource);
    }
}
