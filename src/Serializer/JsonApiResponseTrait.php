<?php

namespace NilPortugues\Symfony\JsonApiBundle\Serializer;

use NilPortugues\Api\JsonApi\Http\Response\BadRequest;
use NilPortugues\Api\JsonApi\Http\Response\ResourceCreated;
use NilPortugues\Api\JsonApi\Http\Response\ResourceDeleted;
use NilPortugues\Api\JsonApi\Http\Response\ResourceNotFound;
use NilPortugues\Api\JsonApi\Http\Response\ResourceProcessing;
use NilPortugues\Api\JsonApi\Http\Response\ResourceUpdated;
use NilPortugues\Api\JsonApi\Http\Response\Response;
use NilPortugues\Api\JsonApi\Http\Response\UnprocessableEntity;
use NilPortugues\Api\JsonApi\Http\Response\UnsupportedAction;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

trait JsonApiResponseTrait
{
    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    protected function addHeaders(ResponseInterface $response)
    {
        return $response;
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function errorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new BadRequest($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceCreatedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new ResourceCreated($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceDeletedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new ResourceDeleted($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceNotFoundResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new ResourceNotFound($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePatchErrorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new UnprocessableEntity($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePostErrorResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new UnprocessableEntity($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceProcessingResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new ResourceProcessing($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceUpdatedResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new ResourceUpdated($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function response($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new Response($json)));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unsupportedActionResponse($json)
    {
        return (new HttpFoundationFactory())
            ->createResponse($this->addHeaders(new UnsupportedAction($json)));
    }
}
