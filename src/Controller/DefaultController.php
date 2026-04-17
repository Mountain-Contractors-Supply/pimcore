<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class DefaultController extends AbstractController
{
    public function defaultAction(): Response
    {
        return $this->render('default/default.html.twig');
    }

    public function fullWidthAction(): Response
    {
        return $this->render('cms/full-width.html.twig', [
            'noBreadcrumbs' => true,
        ]);
    }

    public function leftColumnAction(): Response
    {
        return $this->render('cms/left-column.html.twig', [
            'noBreadcrumbs' => true,
        ]);
    }

    public function fullWidthWithBreadcrumbsAction(): Response
    {
        return $this->render('cms/full-width.html.twig');
    }

    public function leftColumnWithBreadcrumbsAction(): Response
    {
        return $this->render('cms/left-column.html.twig');
    }

}
