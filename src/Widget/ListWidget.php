<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class ListWidget extends AbstractWidget
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $this->configureDefaultOptions($resolver);

        $resolver->define('title_html')
            ->allowedTypes('bool')
            ->default(false);

        $resolver->define('description_html')
            ->allowedTypes('bool')
            ->default(false);

        $resolver->define('definition_html')
            ->allowedTypes('bool')
            ->default(false);

        $resolver->define('list')
            ->required()
            ->allowedTypes('null', 'array[]')
            ->allowedValues(static function (array &$lines): bool {
                $subResolver = new OptionsResolver();
                $subResolver->define('href')
                    ->allowedTypes('string');

                $subResolver->define('title')
                    ->required()
                    ->allowedTypes('string');

                $subResolver->define('description')
                    ->allowedTypes('string');

                $subResolver->define('definition')
                    ->allowedTypes('string');

                $lines = array_map([$subResolver, 'resolve'], $lines);
                return true;
            });
    }

    public function getTemplatePath(): string
    {
        return '@Widget/list_widget.html.twig';
    }
}
