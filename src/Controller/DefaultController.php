<?php

namespace Acme\BlogBundle\Controller;

use Acme\BlogBundle\MonService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends AbstractController
{
    # services are injected in constructor 
    # because "acme_blog.default_controller" has no container set, 
    # did you forget to define it as a service subscriber?

    private $monService;

    public function __construct(MonService $monService)
    {
        $this->monService = $monService;
    }

    public function index()
    {
        dd($this->monService);
        
        return $this->render('@AcmeBlog/index.html.twig');
    }
}