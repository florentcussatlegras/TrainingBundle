<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnnotationController extends AbstractController
{
    /**
     * @Route("/test-annotation")
     */
    public function index(): Response
    {
        return new Response("Hello world");
    }
}