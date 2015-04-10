<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/31/15
 * Time: 11:39 AM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\PayloadBuilders\File;
use PHPUnit_Framework_TestCase;
use Incraigulous\ContentfulSDK\PayloadBuilders\Asset;
use Incraigulous\ContentfulSDK\PayloadBuilders\AssetField;

class AssetPayloadBuilderTests extends PHPUnit_Framework_TestCase {

    function testObjectifyFieldsObjects() {
            $entry = new Asset([
                new AssetField('title', 'Bacon Pancakes'),
                new File("image/jpeg", "example.jpg", "https://example.com/example.jpg")
            ]);
            $result = $entry->make();
            $this->compare[] = $result;
            $this->assertTrue(is_array($result));
            foreach($result['fields'] as $field) {
                $this->assertTrue(is_object($field));
                $fieldResult = $field->make();
                $this->assertTrue(is_array($fieldResult));
            }
    }

    function testObjectifyFieldsArrays() {
        $entry = new Asset([
            ['title' => ['en-us' => 'Bacon Pancakes']],
            ['file' => ['en-us' => ["contentType" => "image/jpeg", "fileName" => "example.jpg", "upload" => "https://example.com/example.jpg"]]]
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
        $objectAsset = new Asset([
            new AssetField('title', 'Bacon Pancakes'),
            new File("image/jpeg", "example.jpg", "https://example.com/example.jpg")
        ]);
        $object = $objectAsset->make();
        $arrayAsset = new Asset([
            ['title' => ['en-us' => 'Bacon Pancakes']],
            ['file' => ['en-us' => ["contentType" => "image/jpeg", "fileName" => "example.jpg", "upload" => "https://example.com/example.jpg"]]]
        ]);
        $array = $arrayAsset->make();
        $this->assertEquals(json_encode($object), json_encode($array));
    }
}