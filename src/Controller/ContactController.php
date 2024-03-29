<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/contact', name: 'contact_')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'new')]
    public function new(Request $request, ContactRepository $contactRepository, MailerInterface $mailer): Response
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->add($contact, true);

            $email = (new Email())
            ->from($contact->getEmail())
            ->to('gaelle@endogirl.fr')
            ->subject('Nouveau message de ' . $contact->getName() . ' à propos de : ' . $contact->getSubject())
            ->text($contact->getMessage());
            $mailer->send($email);

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
