<?php

namespace Hl\WidgetBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Hl\WidgetBundle\DependencyInjection\WidgetExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * WidgetBundle
 * v1.0.0
 */
class WidgetBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new WidgetExtension();
    }
}
