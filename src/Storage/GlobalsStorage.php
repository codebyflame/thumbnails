<?php

namespace CodeByFlame\Thumbnails\Storage;

use Illuminate\Support\Collection;
use Statamic\Sites\Site as SiteObject;
use Statamic\Facades\File;
use Statamic\Facades\Site;
use Statamic\Facades\YAML;

class GlobalsStorage implements Storage
{
    const prefix = 'thumbnails';

    /**
     * Retrieve YAML data from storage
     *
     * @param string $handle
     * @param Site $site
     * @param bool $returnCollection
     *
     * @return array|Collection
     */
    public static function getYaml(string $handle, SiteObject $site, bool $returnCollection = false)
    {
        $path = storage_path(implode('/', [
            'statamic/addons/thumbnails',
            self::prefix . '_' . "{$handle}.yaml",
        ]));

        $data = YAML::parse(File::get($path));

        $site_data = collect($data)->get($site->handle());

        if ($returnCollection) {
            return collect($site_data);
        }

        return collect($site_data)->toArray() ?: [];
    }

    /**
     * Put YAML data into storage
     *
     * @param string $handle
     * @param Site $site
     * @param array $data
     *
     * @return void
     */
    public static function putYaml(string $handle, SiteObject $site, array $data)
    {
        $path = storage_path(implode('/', [
            'statamic/addons/thumbnails',
            self::prefix . '_' . "{$handle}.yaml",
        ]));

        $existing = collect(YAML::parse(File::get($path)));

        $combined_data = $existing->merge([
            "{$site->handle()}" => $data,
        ]);

        File::put($path, YAML::dump($combined_data->toArray()));
    }
}
