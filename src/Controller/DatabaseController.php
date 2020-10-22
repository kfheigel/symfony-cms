<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DatabaseController extends AbstractController
{
    /**
     * @Route("/db", name="database")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('database/database.html.twig', [
            'users' => $users,
        ]);
    }
}
