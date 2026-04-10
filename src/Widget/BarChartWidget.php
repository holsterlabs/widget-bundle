<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class BarChartWidget extends AbstractWidget
{

    public function __construct(array $options = [])
    {
        $this->options = $options;

        foreach ($options['data']['datasets'] as $key => $dataset) {
            if (!isset($options['data']['datasets'][$key]['backgroundColor'])) {
                $options['data']['datasets'][$key]['backgroundColor'] = [
                    $this->getColor($key, $options['backgroundOpacity'] ?? $this->backgroundOpacity)
                ];
            }
            if (!isset($options['data']['datasets'][$key]['borderColor'])) {
                $options['data']['datasets'][$key]['borderColor'] = $this->getColor($key, $options['borderOpacity'] ?? $this->borderOpacity);
            }
            if (!isset($options['data']['datasets'][$key]['borderWidth'])) {
                $options['data']['datasets'][$key]['borderWidth'] = 1;
            }
        }

        $this->options['data'] = [
            'type' => 'bar',
            'data' => $options['data'],
            'options' => [
                'scales' => [
                    'x' => [
                        'grid' => [
                            'color' => 'rgba(255,255,255,.1)',
                            'borderColor' => 'rgba(255,255,255,.1)'
                        ]
                    ],
                    'y' => [
                        'grid' => [
                            'color' => 'rgba(255,255,255,.1)',
                            'borderColor' => 'rgba(255,255,255,.1)'
                        ]
                    ],
                ],
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

        // dd($this->options);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $this->configureDefaultOptions($resolver);
        $resolver->setDefaults([
            'data' => [],
        ]);
    }

    public function getTemplatePath(): string
    {
        return '@Widget/chart_widget.html.twig';
    }
}
