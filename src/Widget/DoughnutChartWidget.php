<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class DoughnutChartWidget extends AbstractWidget
{
    public function __construct(array $options = [])
    {
        $this->options = $options;

        foreach ($options['data']['datasets'] as $key => $dataset) {
            $count = count($options['data']['datasets'][$key]['data']);
            if (!isset($options['data']['datasets'][$key]['backgroundColor'])) {
                $options['data']['datasets'][$key]['backgroundColor'] = $this->getColors($count, $options['backgroundOpacity'] ?? $this->backgroundOpacity);
            }
            if (!isset($options['data']['datasets'][$key]['borderColor'])) {
                $options['data']['datasets'][$key]['borderColor'] = $this->getColors($count, $options['borderOpacity'] ?? $this->borderOpacity);
            }
        }

        $this->options['data'] = [
            'type' => 'doughnut',
            'data' => $options['data'],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                        'labels' => [
                            'color' => '#fff'
                        ]
                    ],
                ]
            ]
        ];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->configureDefaultOptions($resolver);

        $resolver->setDefaults([
            'data' => function (OptionsResolver $dataResolver) {
                $dataResolver->setDefaults([
                    'type' => 'doughnut',
                    'options' => [],
                    'data' => function (OptionsResolver $dataResolver) {
                        $dataResolver->setDefaults([
                            'labels' => [],
                            // 'datasets' => []
                        ])
                            ->setAllowedTypes('labels', 'array');
                        $dataResolver->define('datasets')
                            ->allowedTypes('null', 'array[]')
                            ->allowedValues(static function (array &$links): bool {
                                $subResolver = new OptionsResolver();
                                $subResolver->define('label')
                                    ->required()
                                    ->allowedTypes('string');

                                $subResolver->define('data')
                                    ->required()
                                    ->allowedTypes('array');
                                $subResolver->define('borderColor')
                                    ->allowedTypes('array');
                                $subResolver->define('backgroundColor')
                                    ->allowedTypes('array');
                                $links = array_map([$subResolver, 'resolve'], $links);
                                return true;
                            });
                    }
                ]);
            }
        ]);
    }

    public function getTemplatePath(): string
    {
        return '@Widget/chart_widget.html.twig';
    }
}
