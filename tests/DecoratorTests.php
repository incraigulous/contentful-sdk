<?php
/**
 * Created by PhpStorm.
 * User: craigwann1
 * Date: 3/31/15
 * Time: 8:02 PM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\RequestDecorator;
use PHPUnit\Framework\TestCase;

class DecoratorTests extends TestCase
{
    public function testSetResource(): void
    {
        $decorator = new RequestDecorator();
        $decorator->setResource('test');
        $resource = $decorator->makeResource();
        $this->assertEquals('test', $resource);
    }

    public function testSetId(): void
    {
        $decorator = new RequestDecorator();
        $decorator->setId('test');
        $resource = $decorator->makeResource();
        $this->assertEquals('/test', $resource);
    }

    public function testAddParemater(): void
    {
        $decorator = new RequestDecorator();
        $decorator->addParameter('1', '=', '9');
        $decorator->addParameter('2', '=', '8');
        $decorator->addParameter('3', '=', '7');
        $decorator->addParameter('4', '=', '6');
        $decorator->addParameter('5', '=', '5');
        $resource = $decorator->makeQuery();
        $this->assertCount(5, $resource);
        $this->assertEquals(6, $resource[4]);
    }

    public function testAddHeader(): void
    {
        $decorator = new RequestDecorator();
        $decorator->addHeader('cat', 'dog');
        $decorator->addHeader('dog', 'cat');
        $resource = $decorator->makeHeaders();
        $this->assertCount(2, $resource);
        $this->assertEquals('dog', $resource['cat']);
        $this->assertEquals('cat', $resource['dog']);
    }
}
