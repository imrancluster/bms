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
        if( isset($_POST['submit']) ) {

            $message = \Swift_Message::newInstance()
                ->setSubject('BMS Feedback')
                ->setFrom('noreply@pydream.com')
                ->setTo('imrancluster@gmail.com')
                ->setBody(
                    $this->renderView(
                        'PublicBundle:Default:contactemail.html.twig', array(
                            'message'   => $_POST['message'],
                            'name'      => $_POST['name'],
                            'email'     => $_POST['name']
                        ))
                    )
                ;
                $message->setContentType("text/html");

            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('notice', 'Hello Mr./Mrs. '. $_POST['name'] .', your feedback successfully submitted!!!' );

            return $this->redirect($this->generateUrl("public_homepage"));

        } else {

            $data = "Contact Page";

            return $this->render('PublicBundle:Default:contact.html.twig', array(
                'contact' => $data
            ));

        }

    }

    public function dashboardAction()
    {
        $data = "Dasboard Page";

        return $this->render('PublicBundle:Default:dashboard.html.twig', array(
            'data'  => $data,
            'title' => "Dashbaord"
        ));
    }


}
