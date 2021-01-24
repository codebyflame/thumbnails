<?php

namespace CodeByFlame\Thumbnails\Events;

use Statamic\Events\Event;
use Statamic\Contracts\Git\ProvidesCommitMessage;

class ThumbnailsGlobalsUpdated extends Event implements ProvidesCommitMessage
{
    /**
     * @var string
     */
    public $handle;

    public function __construct(string $handle)
    {
        $this->handle = $handle;
    }

    public function commitMessage(): string
    {
        return 'Thumbnails globals saved';
    }
}
