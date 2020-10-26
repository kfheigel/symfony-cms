<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\RandomStringService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataFlushController extends AbstractController
{
    /**
     * @Route("/db-flush", name="db_flush")
     */
    public function db_flush(RandomStringService $randomString)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail($randomString->randomString(10).'@gmail.com');
        $user->setCreatedAt(new \DateTime());
        $user->setPassword('password_'.$randomString->randomString(10));
        $user->setUsername('user_'.$randomString->randomString(3));

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('database');
    }   
}