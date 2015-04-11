<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/30/15
 * Time: 9:39 PM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use GuzzleHttp\Post\PostBody;
use Incraigulous\ContentfulSDK\DeliveryClient;
use Incraigulous\ContentfulSDK\ManagementClient;
use Incraigulous\ContentfulSDK\ManagementResources\Assets as ManagementAssets;
use Incraigulous\ContentfulSDK\Resources\Assets;
use Incraigulous\ContentfulSDK\ManagementResources\Entries as ManagementEntries;
use Incraigulous\ContentfulSDK\Resources\Entries;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use PHPUnit_Framework_TestCase;

class ClientTests extends PHPUnit_Framework_TestCase {
    protected function getAssets() {
        return [
            new Assets('asdfasdfklj', 'asdfasdf'),
            new ManagementAssets('asdfasdfklj', 'asdfasdf')
        ];
    }

    protected function getEntries() {
        return [
            new Entries('asdfasdfklj', 'asdfasdf'),
            new ManagementEntries('asdfasdfklj', 'asdfasdf')
        ];
    }

    protected function attachSuccessful($resource) {
        $client = $resource->Client()->getClient();

        $mock = new Mock([
            new Response(200),
        ]);
        $client->getEmitter()->attach($mock);

        $resource->Client()->setClient($client);
        return $resource;

    }

    public function testGet() {
        foreach($this->getEntries() as $resource) {
            $resource = $this->attachSuccessful($resource);
            $response = $resource->get();
            $this->assertNull($response);
        }
    }

    public function testPost() {
        $resource = $this->attachSuccessful(new ManagementEntries('asdfasdfklj', 'asdfasdf'));
        $response = $resource->post(array('fields' => array('cat' => 'dog')));
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testPut() {
        $resource = $this->attachSuccessful(new ManagementEntries('asdfasdfklj', 'asdfasdf'));
        $response = $resource->put('asdfasdf', array('fields' => array('cat' => 'dog')));
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testDelete() {
        $resource = $this->attachSuccessful(new ManagementEntries('asdfasdfklj', 'asdfasdf'));
        $response = $resource->delete('asdfasdf');
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testProcess() {
        $resource = $this->attachSuccessful(new ManagementAssets('asdfasdfklj', 'asdfasdf'));
        $response = $resource->process('asdfasdf');
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testArchive() {
        $resource = $this->attachSuccessful(new ManagementAssets('asdfasdfklj', 'asdfasdf'));
        $response = $resource->archive('asdfasdf');
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testUnarchive() {
        $resource = $this->attachSuccessful(new ManagementAssets('asdfasdfklj', 'asdfasdf'));
        $response = $resource->unarchive('asdfasdf');
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testPublish() {
        $resource = $this->attachSuccessful(new ManagementAssets('asdfasdfklj', 'asdfasdf'));
        $response = $resource->publish('asdfasdf', 234);
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testUnpublish() {
        $resource = $this->attachSuccessful(new ManagementAssets('asdfasdfklj', 'asdfasdf'));
        $response = $resource->unpublish('asdfasdf', 123);
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testGetBearer() {
        $client = new ManagementClient('accessToken', 'space');
        $bearer = $client->getBearer();
        $this->assertEquals(' Bearer accessToken', $bearer);

    }

    public function testGetEndpoint() {
        $client = new ManagementClient('accessToken', 'space');
        $endpoint = $client->getEndpoint();
        $this->assertEquals('https://api.contentful.com/spaces/space', $endpoint);
    }

    public function testBuildUrl() {
        //No space, no resource
        $client = new ManagementClient('accessToken', null);
        $endpoint = $client->build_url(null, array());
        $this->assertEquals('https://api.contentful.com/spaces', $endpoint);

        //No space
        $client = new ManagementClient('accessToken', null);
        $endpoint = $client->build_url('test', array());
        $this->assertEquals('https://api.contentful.com/spaces/test', $endpoint);

        //Space and resource
        $client = new ManagementClient('accessToken', 'spaceId');
        $endpoint = $client->build_url('test', array());
        $this->assertEquals('https://api.contentful.com/spaces/spaceId/test', $endpoint);

        //Space, resource and query string
        $client = new ManagementClient('accessToken', 'spaceId');
        $endpoint = $client->build_url('test', array('query' => 'value'));
        $this->assertEquals('https://api.contentful.com/spaces/spaceId/test?query=value', $endpoint);

        //Space, resource and two query strings
        $client = new ManagementClient('accessToken', 'spaceId');
        $endpoint = $client->build_url('test', array('query' => 'value', 'query2' => 'value2'));
        $this->assertEquals('https://api.contentful.com/spaces/spaceId/test?query=value&query2=value2', $endpoint);
    }

    function testBuildCacheKey() {
        $client = new ManagementClient('accessToken', 'spaceId');
        $key = $client->buildCacheKey('method', 'resource', 'url', array('headers'), array('query'));
        $this->assertNotNull($key);
        $key2 = $client->buildCacheKey('1method', '2resource', '3url', array('headers'), array('query'));
        $this->assertNotEquals($key, $key2);
        $key3 = $client->buildCacheKey('1method', '2resource', '3url', array('headers'));
        $this->assertNotEquals($key2, $key3);
        $key4 = $client->buildCacheKey('method', 'resource', 'url', array('headers'), array('query'));
        $this->assertEquals($key, $key4);
    }
}