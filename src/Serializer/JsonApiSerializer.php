<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 8/22/15
 * Time: 12:33 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Symfony2\JsonApiBundle\Serializer;

use NilPortugues\Api\JsonApi\JsonApiTransformer;
use NilPortugues\Api\Mapping\Mapping;
use NilPortugues\Serializer\Serializer;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Acl\Exception\Exception;

/**
 * Class JsonApiSerializer.
 */
class JsonApiSerializer extends Serializer
{
    /**
     * @param JsonApiTransformer $transformer
     * @param Router             $router
     */
    public function __construct(JsonApiTransformer $transformer, Router $router)
    {
        $this->mapUrls($transformer, $router);
        parent::__construct($transformer);
    }

    /**
     * @param JsonApiTransformer $transformer
     * @param Router             $router
     */
    private function mapUrls(JsonApiTransformer $transformer, Router $router)
    {
        $reflectionClass = new ReflectionClass($transformer);
        $reflectionProperty = $reflectionClass->getProperty('mappings');
        $reflectionProperty->setAccessible(true);
        $mappings = $reflectionProperty->getValue($transformer);

        foreach ($mappings as &$mapping) {
            $mappingClass = new ReflectionClass($mapping);

            $this->setUrlWithReflection($router, $mapping, $mappingClass, 'resourceUrlPattern');
            $this->setUrlWithReflection($router, $mapping, $mappingClass, 'selfUrl');

            $mappingProperty = $mappingClass->getProperty('otherUrls');
            $mappingProperty->setAccessible(true);
            $otherUrls = $mappingProperty->getValue($mapping);
            foreach ($otherUrls as &$url) {
                $url = $this->getUrlPattern($router, $url);
            }
            $mappingProperty->setValue($mapping, $otherUrls);

            $mappingProperty = $mappingClass->getProperty('relationshipSelfUrl');
            $mappingProperty->setAccessible(true);
            $relationshipSelfUrl = $mappingProperty->getValue($mapping);
            foreach ($relationshipSelfUrl as &$urlMember) {
                foreach ($urlMember as &$url) {
                    $url = $this->getUrlPattern($router, $url);
                }
            }
            $mappingProperty->setValue($mapping, $relationshipSelfUrl);
        }

        $reflectionProperty->setValue($transformer, $mappings);
    }

    /**
     * @param Router          $router
     * @param Mapping         $mapping
     * @param ReflectionClass $mappingClass
     * @param string          $property
     */
    private function setUrlWithReflection(Router $router, Mapping $mapping, ReflectionClass $mappingClass, $property)
    {
        $mappingProperty = $mappingClass->getProperty($property);
        $mappingProperty->setAccessible(true);
        $value = $mappingProperty->getValue($mapping);
        $value = $this->getUrlPattern($router, $value);
        $mappingProperty->setValue($mapping, $value);
    }

    /**
     * @param Router $router
     * @param string $routeNameFromMappingFile
     *
     * @return mixed
     *
     * @throws \RuntimeException
     */
    private function getUrlPattern(Router $router, $routeNameFromMappingFile)
    {
        if (!empty($routeNameFromMappingFile)) {
            try {
                $route = $router->getRouteCollection()->get($routeNameFromMappingFile);
                if (empty($route)) {
                    throw new Exception();
                }
            } catch (\Exception $e) {
                throw new \RuntimeException(
                   sprintf('Route \'%s\' has not been defined as a Symfony route.', $routeNameFromMappingFile)
               );
            }

            preg_match_all('/{(.*?)}/', $route->getPath(), $matches);

            $pattern = [];
            if (!empty($matches)) {
                $pattern = array_combine($matches[1], $matches[0]);
            }

            return urldecode($router->generate($routeNameFromMappingFile, $pattern, true));
        }

        return (string) $routeNameFromMappingFile;
    }
}
