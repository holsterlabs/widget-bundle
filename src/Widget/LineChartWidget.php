<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class LineChartWidget extends AbstractWidget
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
                $options['data']['datasets'][$key]['borderWidth'] = 2;
            }
        }

        $this->options['data'] = [
            'type' => 'line',
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
            'data' => [],
        ]);
    }

    public function getTemplatePath(): string
    {
        return '@Widget/chart_widget.html.twig';
    }
}
