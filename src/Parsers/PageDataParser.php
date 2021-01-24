<?php

namespace CodeByFlame\Thumbnails\Parsers;

use Illuminate\Support\Facades\URL;
use Statamic\Facades\Collection;
use CodeByFlame\Thumbnails\Generator;

/**
 * Helper class for parsing on-page data
 */
class PageDataParser
{
    /**
     * Return the data we'll be using to compose the thumbnails markup.
     *
     * @param Illuminate\Support\Collection $ctx
     *
     * @return array
     */
    public static function getData($ctx)
    {
        $data = $ctx->map(function ($value, $field) {
            return $value;
        });

        if(!empty($data['id'])) {
            return $data->merge(['thumbnail_path' => url('/thumbnails/' . $data['id'] . '.png')]);
        }

        return $data;
    }
}
