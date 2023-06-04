<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class TextWidget extends AbstractWidget
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $this->configureDefaultOptions($resolver);
        $resolver->setDefaults([
            'text' => '',
        ])
        ->setAllowedTypes('text', 'string');
    }

    public function getTemplatePath(): string
    {
        return '@Widget/text_widget.html.twig';
    }
}
