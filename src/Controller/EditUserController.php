<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditUserController extends AbstractController
{
    /**
     * @Route("/edit/{id}", name="edit_user")
     */
    public function index($id)
    {
        if($this->getUser()->getId()==$id){
            return $this->render('edit_user/index.html.twig', [
                'controller_name' => 'EditUserController',
            ]);
        }else{
            return $this->redirectToRoute('index'); 
        }
        
    }
}
