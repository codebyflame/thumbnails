<?php

namespace CodeByFlame\Thumbnails;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use CodeByFlame\Thumbnails\Tags\ThumbnailsTags;

class ServiceProvider extends AddonServiceProvider
{
	protected $tags = [
        ThumbnailsTags::class,
	];

	protected $routes = [
	    'cp' => __DIR__ . '/../routes/cp.php',
	    'web' => __DIR__ . '/../routes/web.php',
    ];

	protected $scripts = [
        __DIR__ . '/../public/js/thumbnails.js',
    ];

	protected $stylesheets = [
        __DIR__ . '/../public/css/thumbnails.css',
    ];

	public function boot()
	{
		parent::boot();

		// Set up views path
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'thumbnails');

		// Set up translations
		$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'thumbnails');

		// Set up permissions
        $this->bootPermissions();

	    // Set up navigation
        $this->bootNavigation();
	}

	public function bootNavigation()
    {
        Nav::extend(function ($nav) {
           $nav->create('Thumbnails')
               ->section('Content')
               ->route('thumbnails.settings')
               ->icon('telescope');
        });
    }

    public function bootPermissions()
    {
        Permission::register('configure thumbnail settings')
            ->label('Configure Thumbnail Settings');
    }
}
