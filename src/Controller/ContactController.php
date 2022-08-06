<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'new')]
    public function new(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);
            $this->addFlash('success', 'Merci votre message a bien été envoyé');
            return $this->redirectToRoute('contact_new');
        }
        return $this->render(
            'contact/new.html.twig',
            [
            'contact' => $contact,
            'form' => $form->createView(),
            ]
        );
    }

    public function contactView(): Response
    {
        $contact = new Contact();
        $form = $this->createForm(
            ContactType::class,
            $contact,
            [
            'attr' => ['action' => $this->generateUrl('contact_new')]
            ]
        );
        return $this->renderForm(
            'contact/_contactForm.html.twig',
            [
            'form' => $form,
            ]
        );
    }
}
