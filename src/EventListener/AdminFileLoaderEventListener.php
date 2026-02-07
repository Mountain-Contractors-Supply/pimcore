<?php

namespace App\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class AdminFileLoaderEventListener
{
    #[AsEventListener('pimcore.bundle_manager.paths.js')]
    public function addJSFiles(PathsEvent $event): void
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

    #[AsEventListener('pimcore.bundle_manager.paths.css')]
    public function addCSSFiles(PathsEvent $event): void
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                []
            )
        );
    }
}
