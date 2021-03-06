<?php

namespace BMS\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $container = self::$kernel->getContainer();
        $em = $container->get('doctrine');
        $userRepo = $em->getRepository('UserBundle:User');
        $userRepo->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->execute()
        ;

        $crawler = $client->request('GET', '/register');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $this->assertTrue($crawler->filter('html:contains("Register")')->count() > 0);

        // $usernameVal = $crawler->filter('#user_register_username')->attr('value');
        // var_dump($usernameVal);

        // the name of our button is "Register!"
        $form = $crawler->selectButton('Register!')->form();

        $client->submit($form);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertRegexp('/This value should not be blank/', $client->getResponse()->getContent());

        $form['user_register[username]'] = 'user6';
        $form['user_register[email]'] = 'user6@user.com';
        $form['user_register[plainPassword][first]'] = 'P3ssword';
        $form['user_register[plainPassword][second]'] = 'P3ssword';

        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertRegexp('/Registration went super smooth/', $client->getResponse()->getContent());

        // check some basic data about our in the database

        $user = $userRepo->findOneBy(array(
            'username' => 'user6'
        ));

        $this->assertNotNull($user);
        $this->assertNotNull($user->getPassword());
        $this->assertEquals('user6@user.com', $user->getEmail());

    }
}
