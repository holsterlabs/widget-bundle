<?php

namespace Hl\WidgetBundle;

use Twig\Environment;
use Hl\WidgetBundle\Widget\WidgetInterface;
use Symfony\Component\HttpFoundation\Response;

class WidgetBuilder
{
    private $widget;

    public function __construct(private readonly Environment $twig)
    {
    }

    public function createView(WidgetInterface $widget)
    {
        $options = $widget->resolveOptions();

        return new Response($this->twig->render($widget->getTemplatePath(), $options));
    }
}
