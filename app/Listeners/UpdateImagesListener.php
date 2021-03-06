<?php

namespace App\Listeners;


use App\Contracts\ResourceServiceContract;
use App\Events\UpdateImage;

class UpdateImagesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(protected ResourceServiceContract $resource)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UpdateImage $event
     * @return void
     */
    public function handle(UpdateImage $event)
    {
        $this->resource->updateImage($event->file, $event->relation, $event->identifier, $event->path);
    }
}
