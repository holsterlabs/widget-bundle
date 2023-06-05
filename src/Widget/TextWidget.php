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
            'text_html' => false,
        ])
            ->setAllowedTypes('text', 'string')
            ->setAllowedTypes('text_html', 'bool');
    }

    public function getTemplatePath(): string
    {
        return '@Widget/text_widget.html.twig';
    }
}
