<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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
            /** @var UploadedFile $photoFile */
            

            $photoFile = $form->get('userphoto')->getData();
            if($photoFile){
                try{
                    $originalFileName = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFileName = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFileName);
                    $newFilename = $safeFileName.'-'.uniqid().'.'.$photoFile->guessExtension();
                    $photoFile->move('photo', $newFilename);    

                    $user->setUserphoto($newFilename);
                    $user->setCreatedAt(new \DateTime());
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $form->get('password')->getData()
                        )
                    );
                    $em->persist($user);
                    $em->flush(); 
                    $this->addFlash('success', 'User has been edited');
                }catch(\Exception $e){
                    $this->addFlash('error', 'Error, user edit has failed');
                }
            }
            
        }

        return $this->render('edit_user/index.html.twig', [
            'editUserForm' => $form->createView(),
        ]);        
    }
}
