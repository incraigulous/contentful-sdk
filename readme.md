> ***Pardon my mess! Documenting in progress...***

# Contentful SDK for PHP

A modern PHP SDK for Contentful delivery and management APIs.

###This is a framework agnostic PHP SDK. Looking for the Laravel Toolkit?

[Click Here](https://github.com/incraigulous/contentful-laravel) for Laravel facades, a base repository, out-of-the-box caching and cache management, webhook creation by command and more.

> ***New to Contentful?*** [Why I use it and why you should use it.](#why) 

##Installation

Install via composer by running: 

`````
composer require incraigulous/contentful-sdk
`````

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

<anchor name="search"></div>
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

I recommend you cache all Delivery API GET request results (i.e. Memcached or Redis). If you're working with a low traffic website you might be able to get by without caching, but caching will greatly improve performance in any case.

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

Create a new instance of the delivery API:

`````
    use Incraigulous\ContentfulSDK\DeliverySDK;
    $managementSDK = new ManagementSDK('SPACE_ID', 'TOKEN');
`````

**Space ID:** The space to use for calls made by the instance. To use multiple spaces, you should use multiple SDK instances.

**Token:** Your Contentful OAuth token.

####Spaces

#####Creating a space


