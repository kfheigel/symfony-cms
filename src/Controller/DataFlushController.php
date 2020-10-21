<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataFlushController extends AbstractController
{
    /**
     * @Route("/db-flush", name="db_flush")
     */
    public function db_flush()
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setAge(20);
        $user->setEmail('kfheigel@gmail.com');
        $user->setFirstname('Krzysiek');
        $user->setLastname('Heigel');
        $user->setUsername('Kleks');
        $user->setPassword('qwerty');
        $user->setCreatedAt(new \DateTime());
        $user->setUserRole('USER_ROLE');

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('index');
    }   
}