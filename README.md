FullContact PHP Library
================

This is a PHP helper for the FullContact API - http://www.fullcontact.com/

It is modeled after the Twilio PHP Helper library because I think it's generally well done and thought through. This isn't official but should generally work except for the incomplete items in the TODO list below.

This is v0.9.0 so it is pretty stable and I don't expect the interfaces to change much if at all.

## Requirements

This assumes you have cURL installed along with the corresponding php-curl interface. It could be extended to support other HTTP transport tools but I'm kinda lazy.

## Getting started

You have to have a FullContact account. Then copy the creds-dist.php file to creds.php and fill in the API Key. Then you should be able to run any of the scripts in /examples out of the box.

The code itself is pretty simple. You initialize the selected object with the API Key and go from there:

```php
$this->name = new Services_FullContact_Name($apikey);
```

## Testing

This is set up to use a basic PHPUnit configuration. I happened to use 3.7.8 but it shouldn't make a difference. From the root of the project, you should be able to execute the tests using:

```shell
phpunit tests/
```

## TODO

**This library is not complete but here is the active todo list.**

*  For the Person resource
 *  ~~Implement lookup by email and emailMD5~~
  *  Implement style for outputting (lookup by email only)
 *  ~~Implement lookup by phone~~
  *  Implement countryCode for non-US/Canada phone numbers
 *  ~~Implement lookup by twitter~~
 *  Implement lookup by vCard
 *  Implement queue and callback for queue-based processing
 *  --Implement webhookUrl and webhookId for asynchronous processing--
 *  Implement css and prettyPrint for output
 *  Implement Enhanced Lookup retrieval
*  For the Name resource
 *  ~~Implement normalization with casing~~
 *  ~~Implement deducer using email or username with casing~~
 *  ~~Implement similarity with casing~~
 *  Implement stats with casing using ~~name, givenName, familyName,~~ and both (givenName and familyName)
 *  ~~Implement parser with casing~~
*  ~~For the Location resource~~
 *  ~~Implement normalization using includeZeroPopulation and casing~~
 *  ~~Implement enrichment using includeZeroPopulation and casing~~
*  For the Icon resource
 *  ~~Implement the way to get all available icons~~
 *  Implement icon retrieval using size and type
*  Implement the CardShark resource
*  Implement disposable email address detection
*  Implement account stats retrieval
*  ~~Update the library to be backwards compatible with the previous official version~~
*  Update the test to use Mocks instead of live API hits.. because it could drain your account credits. Doh.


## License

All code included is Apache License.

Copyright (C) 2013, FullContact and contributors


Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.