<?php

namespace CodeByFlame\Thumbnails\Tags;

use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Tags\Tags;
use CodeByFlame\Thumbnails\Facades\PageDataParser;

class ThumbnailsTags extends Tags
{
    protected static $handle = 'thumbnails';

    /**
     * Return the <head /> tag content required
     *
     * @return string
     */
    public function index()
    {
        $data = PageDataParser::getData(collect($this->context));

        $view = view('thumbnails::tags.head', $data);

        if ($this->params->get('debug')) {
            return $view;
        }

        return preg_replace(
            [
                "/<!--(.|\s)*?-->/",
                "/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/",
            ],
            [
                '',
                "\n",
            ],
            $view
        );
    }
}
