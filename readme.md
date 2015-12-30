[![Latest Stable Version](https://poser.pugx.org/incraigulous/contentful-sdk/v/stable.svg)](https://packagist.org/packages/incraigulous/contentful-sdk) [![Total Downloads](https://poser.pugx.org/incraigulous/contentful-sdk/downloads.svg)](https://packagist.org/packages/incraigulous/contentful-sdk) [![Latest Unstable Version](https://poser.pugx.org/incraigulous/contentful-sdk/v/unstable.svg)](https://packagist.org/packages/incraigulous/contentful-sdk) [![License](https://poser.pugx.org/leaphly/cart-bundle/license.svg)](https://packagist.org/packages/leaphly/cart-bundle) [![Daily Downloads](https://poser.pugx.org/incraigulous/contentful-sdk/d/daily.png)](https://packagist.org/packages/incraigulous/contentful-sdk) [![Build Status](https://travis-ci.org/incraigulous/contentful-sdk.svg?branch=master)](https://travis-ci.org/incraigulous/contentful-sdk)

# Contentful SDK for PHP

A modern PHP SDK for Contentful delivery and management APIs.

###This is a framework agnostic PHP SDK. 

####Looking for the Laravel Toolkit?

[Click Here](https://github.com/incraigulous/contentful-laravel) for Laravel facades, a base repository, out-of-the-box caching and cache management, webhook creation by command and more.

> ***New to Contentful?*** Contentful is an API driven CMS. Check out their [website](https://www.contentful.com/) and [API documentation](https://www.contentful.com/developers/documentation/content-delivery-api/). 

##Installation

Install via composer by running: 

`````
composer require "incraigulous/contentful-sdk:0.0.*"
`````

##How to use it

###Content Delivery API

####Initializing

Create a new instance of the delivery SDK:

`````
    use Incraigulous\ContentfulSDK\DeliverySDK;
    $deliverySDK = new DeliverySDK('TOKEN', 'SPACE_ID', $cacher, $preview);
`````

**Token:** Your Contentful API token. You can generate this using the Contentful control panel.

**Space ID:** *(optional)* The space to use for calls made by the instance. To use multiple spaces, you should use multiple SDK instances. If you don't provide a space ID, you'll only be able to use the `spaces` resource.

**Cacher:** *(optional, Incraigulous\ContentfulSDK\CacherInterface Implementation)* An object to handle caching. This is optional (and easy to implement), so don't let it scare you off. Check out the [caching](https://github.com/incraigulous/contentful-sdk/blob/master/readme.md#caching) section for more details.

**Preview:** *(optional)* Set to `TRUE` to use the preview API, displaying drafts as well as published content.  Ensure your `TOKEN` is a preview token as well.

####Spaces

#####Getting all spaces

`````
$result = $deliverySDK->spaces()->get();
`````

#####Getting a space

`````
$result = $deliverySDK->spaces()
				->find('SPACE_ID')
				->get();
`````

####Content Types

#####Getting a content type

`````
$result = $deliverySDK->contentTypes()
				->find('CONTENT_TYPE_ID')
				->get();
`````

#####Searching content types

`````
$result = $deliverySDK->contentTypes()
				->where('name', '=', 'Blog Post')
				->get();
`````

or

`````
$result = $deliverySDK->contentTypes()
				->where('name', 'ne', 'Blog Post')
				->limit(2)
				->get();
`````

See [Search Parameters](https://github.com/incraigulous/contentful-sdk#search-parameters) to learn how to search for specific things.

####Entries

#####Get an Entry by ID

`````
$result = $deliverySDK->entries()
				->find('ENTRY ID')
				->get();
`````

#####Searching for entries

`````
$result = $deliverySDK->entries()
				->limitByType('CONTENT TYPE ID')
				->where('fields.title', 'match', 'campus')
				->where('fields.location', 'near', '22,23')
				->limit(10)
				->get();
`````

######Including linked entries in search results

`````
$result = $deliverySDK
	->where('sys.id', '=', 'ENTRY ID')
	->includeLinks(3)
	->get();
`````

`includeLinks` takes the number of link levels you want to include.

####Assets

#####List all assets

`````
$result = $deliverySDK->assets()
            	->limit(10)
            	->get();
`````

#####Get an asset by ID

`````
$deliverySDK->assets()
            	->find('ASSET ID')
            	->get();
`````

#####Searching for assets

`````
$result = $deliverySDK->assets()
              ->where('fields.file.details.size', '>=', 350000)
              ->limit(5)
              ->get();
`````

####Search Parameters 

Searching is easy! Just call one or more of the following methods on your resource. The use of where() and limit() on the assets resource as shown above is a great example of searching. 

Method  | Parameters | Description
------------- | ------------- | -------------
find | id | Limit results by ID
where  | field, operator, value | Limit results by operator search
full  | search | Alias for `query`
query  | search | Search all records for text match. See filters below.
order  | orderBy, $reverse = false | Order results by a field
limit  | number | Limit results by a quantity
skip  | number | Skip a quantity of results


#####Where Filter Operators

Accepted Values  | Produces Contentful Operator | Description
------------- | ------------- | -------------
= | = | **Equality:** Search for exact matches
!=, [ne], ne  | [ne] | **Inequality:** Search for exact matches
[in], in  | [in] | **Inclusion:** Search for multiple matches
[nin], nin  | [nin] | **Exclusion:** Search for multiple matches
<, [lt], lt  | [lt] | **Less Than:** Number & date ranges
\>, [gt], gt  | [gt] | **Greater Than:** Number & date ranges
\>=, [gte], gte  | [gte] | **Greater Than or Equal To:** Number & date ranges
match, [match]  | [match] | **Match:** Full-text search on a specific field
near, [near]  | [near] | **Near:** Search for location near position
within, [within]  | [within] | **Within:** Search for location within bounding rectangle
*Anything not listed*  | ['YOUR OPERATOR HERE'] | **Default**

> For more detailed documentation on searching, see [Contentful's API documentation](https://www.contentful.com/developers/documentation/content-delivery-api/).

#####Caching

I recommend you cache all Delivery API GET request results (i.e. Memcached or Redis). If you're working with a low traffic website you might be able to get by without caching, but it will greatly improve performance in any case.

One way would be to wrap all your API GET calls in a cache check, but that could lead to code duplication. Lucky for you, there's a better way.

I've included a cacher interface. Don't worry, it only requires four methods. Just build a class that implements `Incraigulous\ContentfulSDK\CacherInterface` and pass it as the third parameter when you instantiate the SDK. The SDK will handle the rest. Each GET request will be cached with a unique key built from the query using your cacher class.

 
`````
	$cacher = new CustomCacher(); 
    $deliverySDK = new DeliverySDK('SPACE_ID', 'TOKEN', $cacher);
`````

[Here's an example](https://github.com/incraigulous/contentful-laravel/blob/master/src/Incraigulous/Contentful/Cacher.php) using Laravel's Cache helper.

######If you build a generic PHP cacher implementation for Redis or Memcached, submit a pull request. I would love to include it in the repo. 

###Management API

####Initializing

Create a new instance of the management SDK:

`````
    use Incraigulous\ContentfulSDK\ManagementSDK;
    $managementSDK = new ManagementSDK('TOKEN', 'SPACE_ID');
`````

**Token:** Your Contentful OAuth token.

**Space ID:** *(optional)* The space to use for calls made by the instance. To use multiple spaces, you should use multiple SDK instances. If you don't provide a space ID, you'll only be able to use the `spaces` resource.

>Note that there is a third parameter for the cacher. Management API calls are not currently cached to make sure that `GET` requests are up to date to avoid conflicts when updating records. I still wanted to allow a place to provide the cacher just in case I decide to use it for anything. Feel free to ignore it, or provide a cacher for good measure.

####Using Builder Objects
Contentful payloads can be complex, especially when working with `entries` or `assets`. Payload builders are here to help! They're optional helper classes to assist with building payloads. They take care of building payload arrays for you and let you know what options you have along the way. They're especially helpful if your IDE has hinting.

If you don't want to use them, don't use them. The SDK parases the payload looking for builder objects and turns them into arrays before passing requests on to Contentful. As such, you are free to use standard arrays, or arrays made up of payload builder objects.

The following examples will assume you're using the builders you need:

`````
use Incraigulous\ContentfulSDK\PayloadBuilders\Entry;
use Incraigulous\ContentfulSDK\PayloadBuilders\EntryField;
use Incraigulous\ContentfulSDK\PayloadBuilders\Space;
...
`````

####Spaces

#####Creating a space

`````
$result = $managementSDK->spaces()
				->post(
					new Space('My Space')
				);
`````

#####Updating a space

`````
$space = $managementSDK->spaces()
             ->find('SPACE_ID')
             ->get();
             
$space['name'] = 'Outer Space';
$result = $managementSDK->spaces()->put('SPACE_ID', $space);
`````

#####Deleting a space

`````
$result = $managementSDK->spaces()->delete('SPACE_ID');
`````

####Content Types

#####Creating a content type

`````
$result = $managementSDK->contentTypes()
                ->post(
                    new ContentType('Blog Post', 'title', [
                        new ContentTypeField('title', 'Title', 'Text'),
                        new ContentTypeField('body', 'Body', 'Text'),
                    ])
                );
            );
`````

#####Creating a content type with validation and links

`````
$result = $managementSDK->contentTypes()
                ->post(
                    new ContentType('Blog Post', 'title', [
                        new ContentTypeField('title', 'Title', 'Text'),
                        new ContentTypeField('body', 'Body', 'Text'),
                        (new ContentTypeField('author', 'Field List', 'Link'))->setLink('Entry'),
                        (new ContentTypeField('sidebar', 'Field List', 'Array'))->setMultiLink('Entry'),
                        (new ContentTypeField('category', 'Category', 'Text'))->setValidations((new ContentTypeValidation())->in(['Design', 'Development'])),
                    ])
                );
`````

#####Updating a content type

`````
$contentType = $managementSDK->contentTypes()
					->find('CONTENT_TYPE_ID')
					->get();

$contentType['fields'][0]['name'] = 'Post Title';
$result = $managementSDK->contentTypes()->put('CONTENT_TYPE_ID', $contentType);
`````

#####Publishing a content type

`````
$contentType = $managementSDK->contentTypes()
					->find('CONTENT_TYPE_ID')
					->get();

$result = $managementSDK->contentTypes()->publish('CONTENT_TYPE_ID', $contentType);
`````

#####Unublishing a content type

`````
$contentType = $managementSDK->contentTypes()
					->find('CONTENT_TYPE_ID')
					->get();

$result = $managementSDK->contentTypes()->unpublish('CONTENT_TYPE_ID', $contentType);
`````

#####Deleting a content type

`````
$result = $managementSDK->contentTypes()->delete('CONTENT_TYPE_ID');
`````

#####Content Type Payload Builder

Parameters  | Description
------------- | -------------
name | The content type name
displayField  | the title field key
contentTypeFields  | an array of content type fields. Can be a pure array or an array of ContentTypeField builder objects.

#####Content Type Field Payload Builder

Parameters  | Description
------------- | -------------
id | The content type field id
name  | The content type field name
type  | The content type field type
required | (default: false) is the field required
localized | (default: false) is the field localized

Methods  | Parameters | Description
------------- | ------------- | -------------
setLink | linkType (default: Entry) | Add a link to the field
setMultiLink | linkType (default: Entry) | Add multiple links to the field
setValidations | validations | A validations array or a contentTypeValidations payload builder object 

#####Content Type Field Validations Payload Builder

Takes no parameters.

Methods  | Parameters | Description
------------- | ------------- | -------------
size | min (default: null), max (default: null) | Validates that the size of a text, object or array is within a range.
in | set (array) | Validates that the value of a field belongs to a predefined set. It's defined specifying the elements that form the valid set.
regexp | $pattern, $flags (default: null) | Validates that the value of a field matches a Regular Expression.
dateRange | min (default: null), max (default: null) | Validates that the value of a field is within a date range.
assetFileSize | min (default: null), max (default: null) | Validates that the size of an asset is within a range.
assetImageDimensions | height (default: null), width (default: null) | Validates that the dimensions of an image are within a range.

####Entries

#####Creating an entry

`````
$result = $managementSDK->entries()->contentType('CONTENT_TYPE_ID')->post(
            new Entry([
                    new EntryField('title', 'Hello, World!'), //Create a field with only the default language
                    (new EntryField('body'))->addLanguage('en-US', 'Bacon is healthy!') //Add a language to a field.
                ])
        );
`````

Note that you are able to add content to a field without specifying a language. The default default language is `en-US`. To specify a different default language, define a `CONTENTFUL_DEFAULT_LANGUAGE` constant. 

Example: 

`````
define('CONTENTFUL_DEFAULT_LANGUAGE', 'de-DE'); 
`````

#####Creating an entry while specifying an ID

`````
$result = $managementSDK->entries()->put('MY_CUSTOM_ID', 
		new Entry([
                    new EntryField('title', 'Hello, World!'),
                    (new EntryField('body'))->addLanguage('en-US', 'Bacon is healthy!')
                ])
        );
`````

#####Creating an entry with a linked field

`````
$result = $managementSDK->entries()->contentType('CONTENT_TYPE_ID')->post(new Entry([
            new EntryField('title', 'Hello, World!'),
           (new EntryField('body'))->addLanguage('en-US', 'Bacon is healthy!'),
           (new EntryField('sidebar'))->addMultiLink('ENTRY_ID', 'Entry')->addMultiLink('ENTRY_ID', 'Entry'),
           (new EntryField('author'))->addLink('ENTRY_ID', 'Entry')
        ]));
`````


#####Updating an entry

``````
$entry = $managementSDK->entries()
					->find('ENTRY_ID')
					->get();

$entry['fields']['title'] = new EntryField('title', 'Cheese is Healthy!');
$result = $managementSDK->entries()->put('ENTRY_ID', $entry);
``````

#####Publishing an entry

``````
$entry = $managementSDK->entries()->find('ENTRY_ID')->get();
$result = $managementSDK->entries()->publish('ENTRY_ID', $entry);
``````

#####Unpublishing an entry

``````
$entry = $managementSDK->entries()->find('ENTRY_ID')->get();
$result = $managementSDK->entries()->unpublish('ENTRY_ID', $entry);
``````

#####Archiving an entry

``````
$result = $managementSDK->entries()->archive('ENTRY_ID');
``````

#####Unarchiving an entry

``````
$result = $managementSDK->entries()->unarchive('ENTRY_ID');
``````

#####Deleting an entry

``````
$result = $managementSDK->entries()->delete('ENTRY_ID');
``````

#####Entry Payload Builder

Parameters | Description
------------- | -------------
fields  | An array of entry fields. Can be a pure array or an array of EntryField builder objects.

#####Entry Field Payload Builder

Parameters | Description
------------- | -------------
name | The field name
content  | The field content
language  | (default: en-US or CONTENTFUL_DEFAULT_LANGUAGE constant) The default field language.

Methods | Parameters | Description
------------- | ------------- | -------------
addLanguage | languageKey | Add a language to the field.
addLink | id, linkType (default: Entry), languageKey (default: en-US or CONTENTFUL\_DEFAULT\_LANGUAGE constant) | Create a relationship to a resource.
addMultiLink | id, linkType (default: Entry), languageKey (default: en-US or CONTENTFUL\_DEFAULT\_LANGUAGE constant) | Create relationships to resources.

####Assets

#####Creating an asset

`````
$result = $managementSDK->assets()->post(new Asset([
                    new AssetField('title', 'Bacon Pancakes'),
                    new File("image/jpeg", "example.jpg", "https://example.com/example.jpg")
                ])
        );
`````

#####Creating an asset while specifying an ID

`````
$result = $managementSDK->assets()->put('MY_CUSTOM_ID', new Asset([
                    new AssetField('title', 'Bacon Pancakes'),
                    new File("image/jpeg", "example.jpg", "https://example.com/example.jpg")
                ])
        );
`````

#####Updating an asset

`````
$asset = $managementSDK->assets()->find('ASSET_ID')->get();

$asset['fields']['file'] = new File("image/jpeg", "example.jpg", "https://example.com/example.jpg");
$result = $managementSDK->assets()->put('ASSET_ID', $asset);
`````

#####Processing an asset

`````
$result = $managementSDK->assets()->process('ASSET_ID');
`````

#####Publishing an asset

`````
$asset = $managementSDK->assets()->find('ASSET_ID')->get();
$result = $managementSDK->assets()->publish('ASSET_ID', $asset);
`````

#####Unpublishing an asset

`````
$asset = $managementSDK->assets()->find('ASSET_ID')->get();
$result = $managementSDK->assets()->unpublish('ASSET_ID', $asset);
`````

#####Archiving an asset

`````
$result = $managementSDK->assets()->archive('ASSET_ID');
`````

#####Unarchiving an asset

`````
$result = $managementSDK->assets()->unarchive('ASSET_ID');
`````

#####Deleting an asset

`````
$result = $managementSDK->assets()->delete('ASSET_ID');
`````
#####Asset Payload Builder

Parameters | Description
------------- | -------------
fields  | An array of asset fields. Can be a pure array or an array of AssetField builder objects.

#####Asset Field Payload Builder

Parameters | Description
------------- | -------------
name | The field name
content  | The field content
language  | (default: en-US or CONTENTFUL_DEFAULT_LANGUAGE constant) The default field language

Methods | Parameters | Description
------------- | ------------- | -------------
addLanguage | languageKey | Add a language to the field.

#####File Payload Builder

Parameters | Description
------------- | -------------
contentType | The file content type
fileName  | The file name
upload  | The upload path
language  | (default: en-US or CONTENTFUL_DEFAULT_LANGUAGE constant) The language

####Webhooks

#####Creating a webhook

`````
$result = $managementSDK->webhooks()->post(
			new Webhook('http://www.example.com/')
		);
`````

#####Updating a webhook, or creating new a webhook with a set ID

`````
$result = $managementSDK->webhooks()->put('WEBHOOK_ID', 
			new Webhook('http://www.example.com/')
		);
`````

#####Deleting a webhook

`````
$result = $managementSDK->webhooks()->delete('WEBHOOK_ID');
`````

#####Webhook Payload Builder

Parameters | Description
------------- | -------------
url | The callback URL for the webhook

###What's not implemented?

- **[Synchronization](https://www.contentful.com/developers/documentation/content-delivery-api/#sync)**.
- **The Preview API**.
- **Organizations**.

###Contributing

**See a typo or a bug?** Make a pull request.<br />
**What a new feature?** Make a pull request.<br />
**Want a new feature and don't know how to build it?** You can always ask, I might be game if I think it's a good enough idea.

####How you can help
I'm going to make issues for features that I would like implemented. I'll assign them to myself if I plan to take to build them out. If I leave them unasigned, please step up and take it!



