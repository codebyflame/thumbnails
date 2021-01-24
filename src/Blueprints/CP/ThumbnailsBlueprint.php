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
                                'display' => 'Text color'
                            ]
                        ],
                        [
                            'handle' => 'background_color',
                            'field' => [
                                'type' => 'color',
                                'display' => 'Background color'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
