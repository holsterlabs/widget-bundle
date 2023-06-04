<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class AbstractWidget implements WidgetInterface
{
    protected $options;
    protected $twig;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function resolveOptions()
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        return $resolver->resolve($this->options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }

    public function configureDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->define('footer')
            ->allowedTypes('null', 'array[]')
            ->allowedValues(static function (array &$links): bool {
                $subResolver = new OptionsResolver();
                $subResolver->define('href')
                    ->required()
                    ->allowedTypes('string');

                $subResolver->define('label')
                ->required()
                    ->allowedTypes('string');
                $links = array_map([$subResolver, 'resolve'], $links);
                return true;
            });

        $resolver->setDefaults([
            'heading' => null,
            'icon' => null,
            'icon_small' => false,
            'style' => 'primary',
        ])
        ->setAllowedTypes('heading', ['null', 'string'])
        ->setAllowedTypes('icon', ['null', 'string'])
        ->setAllowedTypes('icon_small', ['bool'])
        ->setAllowedTypes('style', ['null', 'string']);

    }

    public function getTemplatePath(): string
    {
        return '@Widget/text_widget.html.twig';
    }
}
