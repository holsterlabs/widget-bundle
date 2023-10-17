<?php

namespace Hl\WidgetBundle\Widget;

use Symfony\Component\OptionsResolver\OptionsResolver;

class BarChartWidget extends AbstractWidget
{
    private $colors = [
        'rgb(54, 162, 235)',
        'rgb(255, 99, 132)',
        'rgb(255, 159, 64, .5)',
        'rgb(255, 205, 86, .5)',
        'rgb(75, 192, 192, .5)',
        'rgb(153, 102, 255, .5)',
        'rgb(201, 203, 207, .5)'
    ];

    private function getColor($i)
    {
        return $this->colors[($i % count($this->colors))];
    }
    public function __construct(array $options = [])
    {
        $this->options = $options;

        foreach ($options['data']['datasets'] as $key => $dataset) {
            if (!isset($options['data']['datasets'][$key]['backgroundColor'])) {
                $options['data']['datasets'][$key]['backgroundColor'] = [
                    $this->getColor($key)
                ];
            }
            if (!isset($options['data']['datasets'][$key]['borderColor'])) {
                $options['data']['datasets'][$key]['borderColor'] = '#fff';
            }
            if (!isset($options['data']['datasets'][$key]['borderWidth'])) {
                $options['data']['datasets'][$key]['borderWidth'] = 2;
            }
        }

        // $options['data']['datasets']['0']['backgroundColor'] = [
        //     'rgb(54, 162, 235)',
        //     // 'rgb(255, 99, 132)',
        //     // 'rgb(255, 159, 64, .5)',
        //     // 'rgb(255, 205, 86, .5)',
        //     // 'rgb(75, 192, 192, .5)',
        //     // 'rgb(153, 102, 255, .5)',
        //     // 'rgb(201, 203, 207, .5)'
        // ];

        // $options['data']['datasets']['0']['borderColor'] = [
        //     'rgb(255, 99, 132)',
        //     'rgb(255, 159, 64)',
        //     'rgb(255, 205, 86)',
        //     'rgb(75, 192, 192)',
        //     'rgb(54, 162, 235)',
        //     'rgb(153, 102, 255)',
        //     'rgb(201, 203, 207)'
        // ];
        // $options['data']['datasets']['0']['backgroundColor'] = '#ff6384';
        // $options['data']['datasets']['0']['borderColor'] = '#fff';
        // $options['data']['datasets']['0']['borderWidth'] = 2;

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
