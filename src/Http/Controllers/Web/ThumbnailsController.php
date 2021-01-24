<?php

namespace CodeByFlame\Thumbnails\Http\Controllers\Web;

use Illuminate\Routing\Controller as LaravelController;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use CodeByFlame\Thumbnails\Generator;
use CodeByFlame\Thumbnails\Blueprints\CP\ThumbnailsBlueprint;
use CodeByFlame\Thumbnails\Facades\ThumbnailsStorage;

class ThumbnailsController extends LaravelController
{
    /**
     * @param string $id
     */
    public function index(string $id)
    {
        $entry = Entry::find($id);
        $settings = self::getSettingsBlueprintWithValues();

        Generator::generate(
            $entry ? $entry->get('title') : 'Page not found',
            [
                'text_color' => $settings->get('text_color')->raw(),
                'background_color' => $settings->get('background_color')->raw()
            ],
        );
    }

    public function demo($text_color = null, $background_color = null)
    {
        $settings = self::getSettingsBlueprintWithValues();

        Generator::generate(
            'Lorem ipsum dolor sit amet',
            [
                'text_color' => $text_color ? $text_color : $settings->get('text_color')->raw(),
                'background_color' => $background_color ? $background_color : $settings->get('background_color')->raw(),
                'targetSize' => '600x315',
                'fontSize' => 23
            ]
        );
    }

    /**
     * @return mixed
     */
    public static function getSettingsBlueprintWithValues()
    {
        $settings = ThumbnailsStorage::getYaml('settings', Site::current());
        $blueprint = ThumbnailsBlueprint::requestBlueprint();

        return $blueprint->fields()->addValues($settings)->augment()->values();
    }
}
