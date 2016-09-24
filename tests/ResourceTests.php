<?php
namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\ManagementResources\Assets as ManagementAssets;
use Incraigulous\ContentfulSDK\Resources\Assets;
use Incraigulous\ContentfulSDK\ManagementResources\Entries as ManagementEntries;
use Incraigulous\ContentfulSDK\Resources\Entries;
use PHPUnit_Framework_TestCase;

class ResourceTests extends PHPUnit_Framework_TestCase
{
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

    public function testFind() {
        foreach($this->getAssets() as $resource) {
            $resource->find('carrot');
            $this->assertContains('carrot', $resource->decorator()->makeResource());
        }
    }

    public function testRefresh() {
        foreach($this->getAssets() as $resource) {
            $resource->find('carrot');
            $resource->refresh();
            $this->assertNotContains('carrot', $resource->decorator()->makeResource());
        }
    }

    public function testQuery() {
        foreach($this->getAssets() as $resource) {
            $resource->where('cat', '!=', 'dog')
                ->where('cat', '=', 'dog')
                ->where('cat', '<', 'dog')
                ->where('cat', '>', 'dog')
                ->where('cat', '>=', 'dog')
                ->where('cat', '<=', 'dog')
                ->where('cat', 'in', 'dog')
                ->where('cat', 'nin', 'dog')
                ->where('cat', 'match', 'dog')
                ->where('cat', 'near', 'dog')
                ->where('cat', 'within', 'dog')
                ->where('cat', 'asdf', 'dog')
                ->limit(10)
                ->order('cat', true)
                ->skip(2);
            $query = $resource->decorator()->makeQuery();

            $this->assertArrayHasKey('cat', $query);
            $this->assertEquals('dog', $query['cat']);
            $this->assertArrayHasKey('cat[ne]', $query);
            $this->assertEquals('dog', $query['cat[ne]']);
            $this->assertArrayHasKey('cat[lt]', $query);
            $this->assertEquals('dog', $query['cat[lt]']);
            $this->assertArrayHasKey('cat[gt]', $query);
            $this->assertEquals('dog', $query['cat[gt]']);
            $this->assertArrayHasKey('cat[gte]', $query);
            $this->assertEquals('dog', $query['cat[gte]']);
            $this->assertArrayHasKey('cat[lte]', $query);
            $this->assertEquals('dog', $query['cat[lte]']);
            $this->assertArrayHasKey('cat[in]', $query);
            $this->assertEquals('dog', $query['cat[in]']);
            $this->assertArrayHasKey('cat[nin]', $query);
            $this->assertEquals('dog', $query['cat[nin]']);
            $this->assertArrayHasKey('cat[match]', $query);
            $this->assertEquals('dog', $query['cat[match]']);
            $this->assertArrayHasKey('cat[near]', $query);
            $this->assertEquals('dog', $query['cat[near]']);
            $this->assertArrayHasKey('cat[within]', $query);
            $this->assertEquals('dog', $query['cat[within]']);
            $this->assertArrayHasKey('cat[asdf]', $query);
            $this->assertEquals('dog', $query['cat[asdf]']);
            $this->assertArrayHasKey('limit', $query);
            $this->assertEquals(10, $query['limit']);
            $this->assertArrayHasKey('skip', $query);
            $this->assertEquals(2, $query['skip']);
            $this->assertArrayHasKey('order', $query);
            $this->assertEquals('-cat', $query['order']);
            $this->assertCount(15, $query);
        }

    }

    public function testSetType() {
        foreach($this->getEntries() as $resource) {
            $resource->limitByType('cat');
            $this->assertContains('cat', $resource->decorator()->makeQuery());
        }
    }

    public function testIncludeLinks() {
        foreach($this->getEntries() as $resource) {
            $resource->includeLinks(10);
            $this->assertEquals(10, $resource->decorator()->makeQuery()['include']);
        }
    }
}