<?php

namespace BMS\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PublicBundle:Default:index.html.twig');
    }

    public function descriptionAction()
    {
    	$data = "Description Page";

    	return $this->render('PublicBundle:Default:description.html.twig', array(
    		'data' => $data
    	));
    }

    public function contactAction()
    {
    	$data = "Contact Page";

    	return $this->render('PublicBundle:Default:contact.html.twig', array(
    		'contact' => $data
    	));
    }
}
