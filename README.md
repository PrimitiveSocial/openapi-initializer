# openapi-initializer

![logo](https://github.com/PrimitiveSocial/openapi-initializer/blob/main/oai.png)

Straight forward Laravel command to scaffold an OpenAPI spec file

Scaffold an OpenAPI spec file in minutes. 

## Requirements

Laravel versions 6.x, 7.x, and 8.x. 

PHP 7.0 or greater. 

## Install
```
composer require primitive/openapi-initializer
```

### Usage

To use the command, you need to run

```
php artisan openapi:create
```

From there, prompts will step through the process with you, asking questions to fill in various bits of information needed to make the OpenAPI specification conform to the specification standard. 

If you do not run

```
php artisan vendor:publish --vendor=Primitive\OpenApiServiceProvider
```

prior to running the Artisan command, the command itself will run the `vendor:publish` command as well as caching the config so we can use it in the command. We tried to be thoughtful when writing this command because we want to create an enjoyable developer experience. 
