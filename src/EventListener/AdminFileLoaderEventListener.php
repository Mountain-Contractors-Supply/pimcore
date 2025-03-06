<?php

namespace App\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class AdminFileLoaderEventListener
{
    public function addJSFiles(PathsEvent $event)
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                [
                    '/admin/js/sidebar-environment-indicator.js',
                ]
            )
        );
    }

    public function addCSSFiles(PathsEvent $event)
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                []
            )
        );
    }
}
