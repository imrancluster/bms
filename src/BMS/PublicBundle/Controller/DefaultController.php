<?php

namespace BMS\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('PublicBundle:Default:index.html.twig', array('name' => $name));
    }
}
