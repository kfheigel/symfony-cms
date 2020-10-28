<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EditUserController extends AbstractController
{
    /**
     * @Route("/edit/{id}", name="edit_user")
     */
    public function index(
        $id,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
        )
    {
        if(!$this->getUser()->getId()==$id){
            return $this->redirectToRoute('index'); 
        }

        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $user->setCreatedAt(new \DateTime());
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
                );
            $em->persist($user);
            $em->flush();
        }

        return $this->render('edit_user/index.html.twig', [
            'editUserForm' => $form->createView(),
        ]);        
    }
}
