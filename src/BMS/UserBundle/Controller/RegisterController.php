<?php

namespace BMS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use BMS\EventBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Yoda\UserBundle\Entity\User;
use Yoda\UserBundle\Form\RegisterFormType;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User controller.
 *
 */
class RegisterController extends Controller
{
	/**
     * 
     * @Route("/register", name="user_register")
     * @Template()
     */
	public function registerAction(Request $request)
	{
		
		$defaultUser = new User();
		$defaultUser->setUsername('foo');

		$form = $this->createForm(new RegisterFormType(), $defaultUser);

		if($request->isMethod('POST')) {
			$form->bind($request);

			if($form->isValid()) {
				// var_dump($form->getData());die;
				$user = $form->getData();
 				

				$em = $this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
			echo "<pre>"; print_r($user);die;

				$request->getSession()
					->getFlashBag()
					->add('success', 'Registration went super smooth!')
				;

				$this->authenticateUser($user);

				$url = $this->generateUrl('event');

				return $this->redirect($url);
			}
		}

		return array('form' => $form->createView());
	}


    // Manually handle authentication system
    private function authenticateUser(UserInterface $user)
    {
    	$providerKey = 'secured_area'; // your firewall name
    	$token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

    	$this->getSecurityContext()->setToken($token);
    }
}