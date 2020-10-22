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
        $user->setEmail('kfheigel@gmail.com');
        $user->setCreatedAt(new \DateTime());
        $user->setPassword('qwerty');
        $user->setUsername('kleks');

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('index');
    }   
}