<?php

namespace NilPortugues\Symfony\JsonApiBundle;

use NilPortugues\Symfony\JsonApiBundle\DependencyInjection\NilPortuguesSymfonyJsonApiExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NilPortuguesSymfonyJsonApiBundle extends Bundle
{
    /**
     * @return \Symfony\Component\DependencyInjection\Extension\ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new NilPortuguesSymfonyJsonApiExtension();
    }
}
