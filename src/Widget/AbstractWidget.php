<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class AbstractWidget implements WidgetInterface
{
    private $colors = [
        [54, 162, 235],
        [255, 99, 132],
        [255, 159, 64],
        [255, 205, 86],
        [75, 192, 192],
        [153, 102, 255],
        [201, 203, 207],
    ];

    protected $options;
    protected $twig;
    protected $backgroundOpacity = .2;
    protected $borderOpacity = 1;

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

    public function configureOptions(OptionsResolver $resolver) {}

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
            'translate' => false,
            'backgroundOpacity' => $this->backgroundOpacity,
            'borderOpacity' => $this->borderOpacity,
            'colors' => $this->colors,
        ])
            ->setAllowedTypes('heading', ['null', 'string'])
            ->setAllowedTypes('icon', ['null', 'string'])
            ->setAllowedTypes('icon_small', ['bool'])
            ->setAllowedTypes('style', ['null', 'string'])
            ->setAllowedTypes('translate', 'bool')
            ->setAllowedTypes('backgroundOpacity', ['float', 'int'])
            ->setAllowedTypes('borderOpacity', ['null', 'float', 'int'])
            ->setAllowedTypes('colors', 'array[]');
    }

    public function getTemplatePath(): string
    {
        return '@Widget/text_widget.html.twig';
    }

    public function getColor(int $i, float $opacity = 1): string
    {
        $colors = $this->options['colors'] ?? $this->colors;
        $color = $colors[($i % count($colors))];
        return "rgba({$color[0]}, {$color[1]}, {$color[2]}, {$opacity})";
    }

    public function getColors(int $count, float $opacity = 1): array
    {
        $result = [];
        $totalColors = count($this->colors);

        for ($i = 0; $i < $count; $i++) {
            $color = $this->colors[$i % $totalColors];
            $result[] = $this->getColor($i, $opacity);
        }

        return $result;
    }
}
