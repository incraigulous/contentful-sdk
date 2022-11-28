<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/31/15
 * Time: 11:39 AM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\EntryField;
use PHPUnit\Framework\TestCase;

class EntryPayloadBuilderTests extends TestCase
{

    public function testObjectifyFieldsObjects(): void
    {
        $entry = new Entry([
            new EntryField('test', 'content'),
            new EntryField('test', 'content')
        ]);
        $result = $entry->make();
        $this->assertTrue(is_array($result));
        foreach ($result['fields'] as $field) {
            $this->assertTrue(is_object($field));
            $fieldResult = $field->make();
            $this->assertTrue(is_array($fieldResult));
        }
    }

    public function testObjectifyFieldsArrays(): void
    {
        $entry = new Entry([
            ['test' => ['en-us' => 'content']],
            ['test' => ['en-us' => 'content']]
        ]);
        $result = $entry->make();
        $this->assertTrue(is_array($result));
        foreach ($result['fields'] as $field) {
            $this->assertTrue(is_object($field));
            $fieldResult = $field->make();
            $this->assertTrue(is_array($fieldResult));
        }
    }

    public function testCompareObjectsAndArrays(): void
    {
        $objectEntry = new Entry([
            new EntryField('test', 'content'),
            new EntryField('test', 'content')
        ]);
        $object = $objectEntry->make();
        $arrayEntry = new Entry([
            ['test' => ['en-us' => 'content']],
            ['test' => ['en-us' => 'content']]
        ]);
        $array = $arrayEntry->make();
        $this->assertEquals(json_encode($object), json_encode($array));
    }
}
