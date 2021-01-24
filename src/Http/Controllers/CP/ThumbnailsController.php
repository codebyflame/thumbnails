<?php

namespace CodeByFlame\Thumbnails\Http\Controllers\CP;

use Statamic\Facades\Collection;
use Statamic\Facades\Site;
use CodeByFlame\Thumbnails\Blueprints\CP\ThumbnailsBlueprint;
use CodeByFlame\Thumbnails\Http\Controllers\CP\Contracts\Publishable;
use CodeByFlame\Thumbnails\Facades\ThumbnailsStorage;
use CodeByFlame\Thumbnails\Events\ThumbnailsGlobalsUpdated;

class ThumbnailsController extends Controller implements Publishable
{
    public function index()
    {
        $data = $this->getData() ? $this->getData() : [];
        $blueprint = $this->getBlueprint();
        $fields = $blueprint->fields()->addValues($data)->preProcess();

        return view('thumbnails::cp.settings', [
            'blueprint' => $blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'title' => 'Thumbnails Settings',
            'values' => $fields->values(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $blueprint = $this->getBlueprint();
        $fields = $blueprint->fields()->addValues($request->all());
        $fields->validate();
        $this->putData($fields->process()->values()->toArray());

        ThumbnailsGlobalsUpdated::dispatch('settings');
    }

    /**
     * @return \CodeByFlame\Thumbnails\Blueprints\Statamic\Facades\Blueprint
     */
    public function getBlueprint()
    {
        return ThumbnailsBlueprint::requestBlueprint();
    }

    /**
     * @return array
     */
    public function getData()
    {
        return ThumbnailsStorage::getYaml('settings', Site::selected());
    }

    /**
     * @param array $data
     */
    public function putData($data)
    {
        return ThumbnailsStorage::putYaml('settings', Site::selected(), $data);
    }
}
