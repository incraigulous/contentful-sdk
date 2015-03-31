<?php
/**
 * Created by PhpStorm.
 * User: craigw
 * Date: 3/31/15
 * Time: 11:39 AM
 */

namespace Incraigulous\ContentfulSDK\Tests;

use Incraigulous\ContentfulSDK\PayloadBuilders\Asset;
use Incraigulous\ContentfulSDK\PayloadBuilders\AssetField;
use Incraigulous\ContentfulSDK\PayloadBuilders\File;
use Incraigulous\ContentfulSDK\PayloadBuilders\ContentType;
use Incraigulous\ContentfulSDK\PayloadBuilders\ContentTypeField;
use Incraigulous\ContentfulSDK\PayloadBuilders\ContentTypeValidation;
use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\Field;
use Incraigulous\ContentfulSDK\PayloadBuilders\Space;
use PHPUnit_Framework_TestCase;
use Incraigulous\ContentfulSDK\ManagementSDK;

class PayloadTests extends PHPUnit_Framework_TestCase {

    protected function get_decorated_diff($old, $new){
        $from_start = strspn($old ^ $new, "\0");
        $from_end = strspn(strrev($old) ^ strrev($new), "\0");

        $old_end = strlen($old) - $from_end;
        $new_end = strlen($new) - $from_end;

        $start = substr($new, 0, $from_start);
        $end = substr($new, $new_end);
        $new_diff = substr($new, $from_start, $new_end - $from_start);
        $old_diff = substr($old, $from_start, $old_end - $from_start);

        $new = "$start>>>>>$new_diff<<<<<$end";
        $old = "$start>>>>>$old_diff<<<<<$end";
        return array("old"=>$old, "new"=>$new);
    }

    function testSpacePayload() {
        $expected = '{"name":"Example Space"}';
        $decorator = (new ManagementSDK('adsf', 'adsf'))->spaces()->decorator();

        $decorator->setPayload(new Space('Example Space'));
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));

        $decorator->setPayload(['name' => 'Example Space']);
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));
    }

    function testContentTypePayload() {
        $expected = '{"name":"Blog Post","displayField":"title","fields":[{"id":"title","name":"Title","type":"Text","required":true,"localized":true},{"id":"body","name":"Body","type":"Text","validations":[{"size":{"min":5}},{"in":[1,2,3]},{"dateRange":{"min":"2013-02-08T09:12Z","max":"2015-12-08"}},{"assetFileSize":{"min":12,"max":100}},{"assetImageDimensions":{"height":{"min":10,"max":200},"width":{"min":20,"max":30}}},{"regexp":{"pattern":"wow|very|such"}}]}]}';
        $decorator = (new ManagementSDK('adsf', 'adsf'))->contentTypes()->decorator();
        $decorator->setPayload(new ContentType('Blog Post', 'title', [
            new ContentTypeField('title', 'Title', 'Text', true, true),
            (new ContentTypeField('body', 'Body', 'Text', false, false))->setValidations((new ContentTypeValidation())->size(5)->in([1,2,3])->dateRange("2013-02-08T09:12Z","2015-12-08")->assetFileSize(12, 100)->assetImageDimensions(['min' => 10, 'max' => 200], ['min' => 20, 'max' => 30])->regexp("wow|very|such"))
        ]));
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));


        $decorator->setPayload(array (
          'name' => 'Blog Post',
          'displayField' => 'title',
          'fields' =>
              array (
                0 =>
                array (
                  'id' => 'title',
                  'name' => 'Title',
                  'type' => 'Text',
                  'required' => true,
                  'localized' => true,
                ),
                1 =>
                array (
                  'id' => 'body',
                  'name' => 'Body',
                  'type' => 'Text',
                  'validations' =>
                  array (
                    0 =>
                    array (
                      'size' =>
                      array (
                        'min' => 5,
                      ),
                    ),
                    1 =>
                    array (
                      'in' =>
                      array (
                        0 => 1,
                        1 => 2,
                        2 => 3,
                      ),
                    ),
                    2 =>
                    array (
                      'dateRange' =>
                      array (
                        'min' => '2013-02-08T09:12Z',
                        'max' => '2015-12-08',
                      ),
                    ),
                    3 =>
                    array (
                      'assetFileSize' =>
                      array (
                        'min' => 12,
                        'max' => 100,
                      ),
                    ),
                    4 =>
                    array (
                      'assetImageDimensions' =>
                      array (
                        'height' =>
                        array (
                          'min' => 10,
                          'max' => 200,
                        ),
                        'width' =>
                        array (
                          'min' => 20,
                          'max' => 30,
                        ),
                      ),
                    ),
                    5 =>
                    array (
                      'regexp' =>
                      array (
                        'pattern' => 'wow|very|such',
                      ),
                    ),
                  ),
                ),
              ),
            )
        );
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));

        $decorator->setPayload(array (
                'name' => 'Blog Post',
                'displayField' => 'title',
                'fields' =>
                    array (
                        0 =>
                            array (
                                'id' => 'title',
                                'name' => 'Title',
                                'type' => 'Text',
                                'required' => true,
                                'localized' => true,
                            ),
                        1 =>
                            array (
                                'id' => 'body',
                                'name' => 'Body',
                                'type' => 'Text',
                                'validations' =>
                                    (new ContentTypeValidation())->size(5)->in([1,2,3])->dateRange("2013-02-08T09:12Z","2015-12-08")->assetFileSize(12, 100)->assetImageDimensions(['min' => 10, 'max' => 200], ['min' => 20, 'max' => 30])->regexp("wow|very|such")
                            ),
                    ),
            )
        );
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));

        $decorator->setPayload(new ContentType('Blog Post', 'title', [
            new ContentTypeField('title', 'Title', 'Text', true, true),
            (new ContentTypeField('body', 'Body', 'Text', false, false))->setValidations(array (
            0 =>
                array (
                    'size' =>
                        array (
                            'min' => 5,
                        ),
                ),
            1 =>
                array (
                    'in' =>
                        array (
                            0 => 1,
                            1 => 2,
                            2 => 3,
                        ),
                ),
            2 =>
                array (
                    'dateRange' =>
                        array (
                            'min' => '2013-02-08T09:12Z',
                            'max' => '2015-12-08',
                        ),
                ),
            3 =>
                array (
                    'assetFileSize' =>
                        array (
                            'min' => 12,
                            'max' => 100,
                        ),
                ),
            4 =>
                array (
                    'assetImageDimensions' =>
                        array (
                            'height' =>
                                array (
                                    'min' => 10,
                                    'max' => 200,
                                ),
                            'width' =>
                                array (
                                    'min' => 20,
                                    'max' => 30,
                                ),
                        ),
                ),
            5 =>
                array (
                    'regexp' =>
                        array (
                            'pattern' => 'wow|very|such',
                        ),
                ),
        ))
        ]));
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));
    }

    function testContentTypeLinks() {
        $expected = '{"name":"Links","displayField":"theLink","fields":[{"id":"thelink","name":"The Link","type":"Array","items":{"type":"Link","linkType":"Asset"},"required":true,"localized":true},{"id":"themulti","name":"The Multi","type":"Link","linkType":"Entry"}]}';
        $decorator = (new ManagementSDK('adsf', 'adsf'))->contentTypes()->decorator();
        $decorator->setPayload(new ContentType('Links', 'theLink', [
            (new ContentTypeField('thelink', 'The Link', 'Array', true, true))->setMultiLink('Asset'),
            (new ContentTypeField('themulti', 'The Multi', 'Link', false, false))->setLink('Entry')
        ]));
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));
    }

    function testEntryPayload() {
        $expected = '{"fields":{"title":{"en-US":"Hello, World!"},"body":{"en-US":"Bacon is healthy!"},"contentList":{"en-US":[{"sys":{"type":"Link","linkType":"Entry","id":"nice-burger"}},{"sys":{"type":"Link","linkType":"Entry","id":"such-dessert"}}]}}}';
        $decorator = (new ManagementSDK('adsf', 'adsf'))->entries()->decorator();

        $decorator->setPayload(new Entry([
            (new Field('title'))->addLanguage('en-US', 'Hello, World!'),
            (new Field('body'))->addLanguage('en-US', 'Bacon is healthy!'),
            (new Field('contentList'))->addLink('nice-burger', 'Entry', 'en-US')->addLink('such-dessert', 'Entry', 'en-US')
        ]));
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload));
    }

    function testAssetPayload() {
        $expected = '{"fields":{"title":{"en-US":"Bacon Pancakes"}},"file":{"en-US":{"contentType":"image/jpeg","fileName":"example.jpg","upload":"https://example.com/example.jpg"}}}';
        $decorator = (new ManagementSDK('adsf', 'adsf'))->entries()->decorator();

        $decorator->setPayload(
            new Asset([
                new AssetField('title', 'Bacon Pancakes'),
            ], new File("image/jpeg", "example.jpg", "https://example.com/example.jpg"))
        );
        $payload = $decorator->makePayload();
        $this->assertEquals($expected, json_encode($payload, JSON_UNESCAPED_SLASHES));
    }

}