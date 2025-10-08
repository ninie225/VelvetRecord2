<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data= $form->getData();
            
            $email = $data['email'];
            $sujet = $data['sujet'];
            $message = $data['message'];

            $mail= (new Email())
            ->from($email)
            ->to('me@example.com')
            ->subject($sujet)
            ->html($message);

            $mailer->send($mail);
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
