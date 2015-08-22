Symfony2 JSON-API Transformer Bundle
=========================================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/jsonapi-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/jsonapi-bundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3269f12e-a707-462a-bef5-22e5ed522e8e/mini.png)](https://insight.sensiolabs.com/projects/3269f12e-a707-462a-bef5-22e5ed522e8e) 
[![Latest Stable Version](https://poser.pugx.org/nilportugues/jsonapi-bundle/v/stable)](https://packagist.org/packages/nilportugues/jsonapi-bundle)
[![Total Downloads](https://poser.pugx.org/nilportugues/jsonapi-bundle/downloads)](https://packagist.org/packages/nilportugues/jsonapi-bundle) 
[![License](https://poser.pugx.org/nilportugues/jsonapi-bundle/license)](https://packagist.org/packages/nilportugues/jsonapi-bundle) 



#### Response objects (JsonApiResponseTrait)

The following `JsonApiResponseTrait` methods are provided to return the right headers and HTTP status codes are available:

```php
    private function errorResponse($json);
    private function resourceCreatedResponse($json);
    private function resourceDeletedResponse($json);
    private function resourceNotFoundResponse($json);
    private function resourcePatchErrorResponse($json);
    private function resourcePostErrorResponse($json);
    private function resourceProcessingResponse($json);
    private function resourceUpdatedResponse($json);
    private function response($json);
    private function unsupportedActionResponse($json);
```    


## Quality

To run the PHPUnit tests at the command line, go to the tests directory and issue phpunit.

This library attempts to comply with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/), [PSR-4](http://www.php-fig.org/psr/psr-4/) and [PSR-7](http://www.php-fig.org/psr/psr-7/).

If you notice compliance oversights, please send a patch via [Pull Request](https://github.com/nilportugues/symfony2-jsonapi-transformer/pulls).


## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/nilportugues/symfony2-jsonapi-transformer/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/nilportugues/symfony2-jsonapi-transformer).


## Support

Get in touch with me using one of the following means:

 - Emailing me at <contact@nilportugues.com>
 - Opening an [Issue](https://github.com/nilportugues/symfony2-jsonapi-transformer/issues/new)
 - Using Gitter: [![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nilportugues/symfony2-jsonapi-transformer?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)


## Authors

* [Nil Portugués Calderó](http://nilportugues.com)
* [The Community Contributors](https://github.com/nilportugues/symfony2-jsonapi-transformer/graphs/contributors)


## License
The code base is licensed under the [MIT license](LICENSE).
