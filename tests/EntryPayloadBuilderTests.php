<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/31/15
 * Time: 11:39 AM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use PHPUnit_Framework_TestCase;
use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\EntryField;

class EntryPayloadBuilderTests extends PHPUnit_Framework_TestCase {

    function testObjectifyFieldsObjects() {
            $entry = new Entry([
                new EntryField('test', 'content'),
                new EntryField('test', 'content')
            ]);
            $result = $entry->make();
            $this->assertTrue(is_array($result));
            foreach($result['fields'] as $field) {
                $this->assertTrue(is_object($field));
                $fieldResult = $field->make();
                $this->assertTrue(is_array($fieldResult));
            }
    }

    function testObjectifyFieldsArrays() {
        $entry = new Entry([
            ['test' => ['en-us' => 'content']],
            ['test' => ['en-us' => 'content']]
        ]);
        $result = $entry->make();
        $this->assertTrue(is_array($result));
        foreach($result['fields'] as $field) {
            $this->assertTrue(is_object($field));
            $fieldResult = $field->make();
            $this->assertTrue(is_array($fieldResult));
        }
    }

    function testCompareObjectsAndArrays() {
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