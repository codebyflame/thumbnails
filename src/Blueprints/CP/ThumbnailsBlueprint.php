<?php

namespace CodeByFlame\Thumbnails\Blueprints\CP;

use CodeByFlame\Thumbnails\Blueprints\Blueprint;
use Statamic\Facades\Blueprint as StatamicBlueprint;

class ThumbnailsBlueprint implements Blueprint
{
    /**
     * @return \Statamic\Fields\Blueprint
     */
    public static function requestBlueprint()
    {
        return StatamicBlueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'text_color',
                            'field' => [
                                'type' => 'color',
                                'display' => __('thumbnails::thumbnails.fields.text_color.display'),
                                'localizable' => true
                            ]
                        ],
                        [
                            'handle' => 'background_color',
                            'field' => [
                                'type' => 'color',
                                'display' => __('thumbnails::thumbnails.fields.background_color.display'),
                                'localizable' => true
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
