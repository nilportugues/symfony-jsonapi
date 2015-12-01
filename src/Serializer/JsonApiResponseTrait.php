<?php

namespace NilPortugues\Symfony\JsonApiBundle\Serializer;

use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

trait JsonApiResponseTrait
{
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function addHeaders(\Psr\Http\Message\ResponseInterface $response)
    {
        return $response;
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function errorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ErrorResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourceCreatedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourceCreatedResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourceDeletedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourceDeletedResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourceNotFoundResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourceNotFoundResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourcePatchErrorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourcePatchErrorResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourcePostErrorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourcePostErrorResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourceProcessingResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourceProcessingResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function resourceUpdatedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\ResourceUpdatedResponse($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function response($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\Response($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function unsupportedActionResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new \NilPortugues\Api\JsonApi\Http\Message\UnsupportedActionResponse($json)));
    }
}
