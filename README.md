Symfony2 JSON-API Transformer Bundle
=========================================

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/symfony2-jsonapi-transformer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/symfony2-jsonapi-transformer/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3269f12e-a707-462a-bef5-22e5ed522e8e/mini.png?)](https://insight.sensiolabs.com/projects/3269f12e-a707-462a-bef5-22e5ed522e8e) 
[![Latest Stable Version](https://poser.pugx.org/nilportugues/jsonapi-bundle/v/stable)](https://packagist.org/packages/nilportugues/jsonapi-bundle)
[![Total Downloads](https://poser.pugx.org/nilportugues/jsonapi-bundle/downloads)](https://packagist.org/packages/nilportugues/jsonapi-bundle) 
[![License](https://poser.pugx.org/nilportugues/jsonapi-bundle/license)](https://packagist.org/packages/nilportugues/jsonapi-bundle) 


## Installation

**Step 1: Download the Bundle**

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```bash
$ composer require nilportugues/jsonapi-bundle
```


**Step 2: Enable the Bundle**

Then, enable the bundle by adding it to the list of registered bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php
// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...
            new NilPortugues\Symfony2\JsonApiBundle\NilPortuguesSymfony2JsonApiBundle(),
        );
        // ...
    }
    // ...
}
```

## Usage

### Creating the mappings

**Mapping directory**

Mapping files should be located at the `app/config/serializer` directory. This directory must be created.

It can be also be customized and placed where desired by editing `app/config/config.yml` file using the configuration file:

```yml
# app/config/config.yml

nilportugues_json_api:
    mappings: "%kernel.root_dir%/config/serializer/"

```

**Mapping files**

The JSON-API transformer works by transforming an existing PHP object into its JSON representation. For each object, a mapping file is required. 

Mapping files **must** be placed in the mappings directory. The expected mapping file format is `.yml` and  will allow you to rename, hide and create links relating all of your data.

For instance, here's a quite complex `Post` object to demonstrate how it works:

```php
$post = new Post(
    new PostId(9),
    'Hello World',
    'Your first post',
    new User(
        new UserId(1),
        'Post Author'
    ),
    [
        new Comment(
            new CommentId(1000),
            'Have no fear, sers, your king is safe.',
            new User(new UserId(2), 'Barristan Selmy'),
            [
                'created_at' => (new DateTime('2015/07/18 12:13:00'))->format('c'),
                'accepted_at' => (new DateTime('2015/07/19 00:00:00'))->format('c'),
            ]
        ),
    ]
);
```

And the series of mapping files required:

```yml
# app/config/serializer/acme_domain_dummy_post.yml

mapping:
  class: Acme\Domain\Dummy\Post
  alias: Message
  aliased_properties:
    author: author
    title: headline
    content: body
  hide_properties: []
  id_properties:
    - postId
  urls:
    self: get_post ## @Route name
    comments: get_post_comments ## @Route name
  relationships:
    author:
      related: get_post_author ## @Route name
      self: get_post_author_relationship  ## @Route name
```

```yml
# app/config/serializer/acme_domain_dummy_value_object_post_id.yml

mapping:
  class: Acme\Domain\Dummy\ValueObject\PostId
  aliased_properties: []
  hide_properties: []
  id_properties:
  - postId
  urls:
    self: get_post  ## @Route name
  relationships:
    comment:
      self: get_post_comments_relationship  ## @Route name
```


```yml
# app/config/serializer/acme_domain_dummy_comment.yml

mapping:
  class: Acme\Domain\Dummy\Comment
  aliased_properties: []
  hide_properties: []
  id_properties:
    - commentId
  urls:
    self: get_comment ## @Route name
  relationships:
    post:
      self: get_post_comments_relationship ## @Route name
```

```yml
# app/config/serializer/acme_domain_dummy_value_object_comment_id.yml

mapping:
  class: Acme\Domain\Dummy\ValueObject\CommentId
  aliased_properties: []
  hide_properties: []
  id_properties:
    - commentId
  urls:
    self: get_comment ## @Route name
  relationships:
    post:
      self: get_post_comments_relationship ## @Route name
```


```yml
# app/config/serializer/acme_domain_dummy_user.yml

mapping:
  class: Acme\Domain\Dummy\User
  aliased_properties: []
  hide_properties: []
  id_properties:
  - userId
  urls:
    self: get_user
    friends: get_user_friends  ## @Route name
    comments: get_user_comments  ## @Route name
```


```yml
# app/config/serializer/acme_domain_dummy_value_object_user_id.yml

mapping:
  class: Acme\Domain\Dummy\ValueObject\UserId
  aliased_properties: []
  hide_properties: []
  id_properties:
  - userId
  urls:
    self: get_user  ## @Route name
    friends: get_user_friends  ## @Route name
    comments: get_user_comments  ## @Route name
```


## Outputing API Responses

It is really easy, just get an instance of the `JsonApiSerializer` from the **Service Container** and pass the object to its `serialize()` method. Output will be valid JSON-API.

Here's an example of a `Post` object being fetched from a Doctrine repository.

Finally, a helper trait, `JsonApiResponseTrait` is provided to write fully compilant responses wrapping the PSR-7 Response objects provided by the original JSON API Transformer library.

```
<?php
namespace AppBundle\Controller;

use NilPortugues\Symfony2\JsonApiBundle\Serializer\JsonApiResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    use JsonApiResponseTrait;

    /**
     * @\Symfony\Component\Routing\Annotation\Route("/post/{postId}", name="get_post")
     *
     * @param $postId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPostAction($postId)
    {
        $post = $this->get('doctrine.post_repository)->find($postId);
        
        $serializer = $this->get('nil_portugues.serializer.json_api_serializer');

        /** @var \NilPortugues\Api\JsonApi\JsonApiTransformer $transformer */
        $transformer = $serializer->getTransformer();
        $transformer->setSelfUrl($this->generateUrl('get_post', ['postId' => $postId], true));
        $transformer->setNextUrl($this->generateUrl('get_post', ['postId' => $postId+1], true));

        return $this->response($serializer->serialize($post));
    }
} 
```


**Output:**

```
HTTP/1.1 200 OK
Cache-Control: private, max-age=0, must-revalidate
Content-type: application/vnd.api+json
```

```json
{
    "data": {
        "type": "message",
        "id": "9",
        "attributes": {
            "headline": "Hello World",
            "body": "Your first post"
        },
        "links": {
            "self": {
                "href": "http://example.com/posts/9"
            },
            "comments": {
                "href": "http://example.com/posts/9/comments"
            }
        },
        "relationships": {
            "author": {
                "links": {
                    "self": {
                        "href": "http://example.com/posts/9/relationships/author"
                    },
                    "related": {
                        "href": "http://example.com/posts/9/author"
                    }
                },
                "data": {
                    "type": "user",
                    "id": "1"
                }
            }
        }
    },
    "included": [
        {
            "type": "user",
            "id": "1",
            "attributes": {
                "name": "Post Author"
            },
            "links": {
                "self": {
                    "href": "http://example.com/users/1"
                },
                "friends": {
                    "href": "http://example.com/users/1/friends"
                },
                "comments": {
                    "href": "http://example.com/users/1/comments"
                }
            }
        },
        {
            "type": "user",
            "id": "2",
            "attributes": {
                "name": "Barristan Selmy"
            },
            "links": {
                "self": {
                    "href": "http://example.com/users/2"
                },
                "friends": {
                    "href": "http://example.com/users/2/friends"
                },
                "comments": {
                    "href": "http://example.com/users/2/comments"
                }
            }
        },
        {
            "type": "comment",
            "id": "1000",
            "attributes": {
                "dates": {
                    "created_at": "2015-08-13T21:11:07+02:00",
                    "accepted_at": "2015-08-13T21:46:07+02:00"
                },
                "comment": "Have no fear, sers, your king is safe."
            },
            "links": {
                "self": {
                    "href": "http://example.com/comments/1000"
                }
            }
        }
    ],
    "links": {
        "self": {
            "href": "http://example.com/posts/9"
        },
        "next": {
            "href": "http://example.com/posts/10"
        }
    },
    "meta": {
        "author": [
            {
                "name": "Nil Portugués Calderó",
                "email": "contact@nilportugues.com"
            }
        ]
    },
    "jsonapi": {
        "version": "1.0"
    }
}
```

#### Request objects

JSON API comes with a helper Request class, `NilPortugues\Api\JsonApi\Http\Message\Request(ServerRequestInterface $request)`, implementing the PSR-7 Request Interface. Using this request object will provide you access to all the interactions expected in a JSON API:

##### JSON API Query Parameters:

- &filter[resource]=field1,field2
- &include[resource]
- &include[resource.field1]
- &sort=field1,-field2
- &sort=-field1,field2
- &page[number]
- &page[limit]
- &page[cursor]
- &page[offset]
- &page[size]


##### NilPortugues\Api\JsonApi\Http\Message\Request

Given the query parameters listed above, Request implements helper methods that parse and return data already prepared.

```php
namespace NilPortugues\Api\JsonApi\Http\Message;

final class Request
{
    public function __construct(ServerRequestInterface $request) { ... }
    public function getQueryParam($name, $default = null) { ... }
    public function getIncludedRelationships($baseRelationshipPath) { ... }
    public function getSortFields() { ... }
    public function getAttribute($name, $default = null) { ... }
    public function getSortDirection() { ... }
    public function getPageNumber() { ... }
    public function getPageLimit() { ... }
    public function getPageOffset() { ... }
    public function getPageSize() { ... }
    public function getPageCursor() { ... }
    public function getFilters() { ... }
}
```

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
