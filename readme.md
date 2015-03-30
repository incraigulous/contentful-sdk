> ***Pardon my mess! Documenting in progress...***

# Contentful SDK for PHP
A modern PHP SDK for Contentful delivery and management APIs.

##Installation
Install via composer by running: 

`````
composer require incraigulous/contentful-sdk
`````

##This is the Generic PHP SDK.<br />Looking for the Laravel Toolkit?
[Click Here](https://github.com/incraigulous/contentful-laravel) for Laravel facades, a base repository, out-of-the-box caching and cache management, webhook creation by command and more.

##How to use it

###Delivery API

####Initializing
Create a new instance of the delivery API:

`````
    use Incraigulous\ContentfulSDK\DeliverySDK;
    $deliverySDK = new DeliverySDK('SPACE_ID', 'TOKEN');
`````

**Space ID:** The space to use for calls made by the instance. To use multiple spaces, you should use multiple SDK instances.

**Token:** Your Contentful API token. You can generate this using the Contentful control panel.

####Spaces

#####Getting the current space
`````
$result = $deliverySDK->spaces()->get();
`````

####Content Types

#####Getting a content type
`````
$result = $deliverySDK->contentTypes('PAGE_ID')->get();
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

See [Search Parameters](#search) to learn how to search for specific things.

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
$result = $deliverySDK->entries()
	           ->limitByType('CONTENT TYPE ID')
	           ->includeLinks(1);
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


###Management API

####Entries
`````
$result = $managementSDK->entries()->contentType('CONTENT_TYPE')->post(new Entry(
            [
                (new Field('contentList'))->addLink('ENTRY_ID')->addLink('ANOTHER_ENTRY_ID'), //Content List Field
                (new Field('title'))->addLanguage('en-US', 'Contact'), //Text Field
                new Field('primaryContent', 'Call us!'), //Text field without specifying a language
                new Field('tags', ['testtag', 'info']) //Symbol list field
            ]
        ));
`````
