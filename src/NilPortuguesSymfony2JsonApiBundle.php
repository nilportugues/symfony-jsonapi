<?php

namespace NilPortugues\Symfony2\JsonApiBundle;

use NilPortugues\Symfony2\JsonApiBundle\DependencyInjection\NilPortuguesSymfony2JsonApiExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NilPortuguesSymfony2JsonApiBundle extends Bundle
{
    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new NilPortuguesSymfony2JsonApiExtension();
    }
}
