<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'dashboard', methods: ['GET', 'POST'])]
    public function profileView(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            $this->addFlash('success', 'Votre profil a bien été mis à jour.');
            return $this->redirectToRoute('profile_dashboard', [], Response::HTTP_SEE_OTHER);
        } 
        return $this->render('profile/dashboard.html.twig', [
            'user' => $userRepository->findOneBy(['id' => $this->getUser()]),
            'form' => $form->createView(),
        ]);
    }
}
