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
use NilPortugues\Api\JsonApi\Server\Errors\Error;
use NilPortugues\Api\JsonApi\Server\Errors\ErrorBag;
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
        $error = new Error('Bad Request', json_decode($json));

        return $this->createResponse(new BadRequest(new ErrorBag([$error])));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceCreatedResponse($json)
    {
        return $this->createResponse(new ResourceCreated($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceDeletedResponse($json)
    {
        return $this->createResponse(new ResourceDeleted($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceNotFoundResponse($json)
    {
        return $this->createResponse(new ResourceNotFound($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePatchErrorResponse($json)
    {
        $error = new Error('Unprocessable Entity', json_decode($json));

        return $this->createResponse(new UnprocessableEntity([$error]));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourcePostErrorResponse($json)
    {
        $error = new Error('Unprocessable Entity', json_decode($json));

        return $this->createResponse(new UnprocessableEntity([$error]));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceProcessingResponse($json)
    {
        return $this->createResponse(new ResourceProcessing($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function resourceUpdatedResponse($json)
    {
        return $this->createResponse(new ResourceUpdated($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function response($json)
    {
        return $this->createResponse(new Response($json));
    }

    /**
     * @param string $json
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unsupportedActionResponse($json)
    {
        $error = new Error('Unsupported Action', json_decode($json));

        return $this->createResponse(new UnsupportedAction([$error]));
    }

    /**
     * @param $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function createResponse($data)
    {
        return (new HttpFoundationFactory())->createResponse($this->addHeaders($data));
    }
}
