<?php

namespace DMD\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('DMDFrontBundle:Blog:index.html.twig');
    }
    
}
