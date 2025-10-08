<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Form\DiscFormType;
use App\Repository\DiscRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CrudController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(DiscRepository $discRepository): Response
    {
        $discs= $discRepository->findAll();
        $nbDiscs = count($discs);

        return $this->render('crud/index.html.twig', [
            'disques' => $discs,
            'nbDiscs' => $nbDiscs,
        ]);
    }

    #[Route('/details/{id}', name: 'app_details')]
    public function details(DiscRepository $discRepository, int $id ): Response
    {
        $disc= $discRepository->find($id);

        return $this->render('crud/details.html.twig', [
            'disque' => $disc,
        ]);
    }

    #[Route('/delete/{id}', name: 'app_delete', methods: ['POST'])]
    public function delete(Request $request, Disc $disc, EntityManagerInterface $em ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disc->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($disc);
            $em->flush();
        }

        return $this->redirectToRoute('app_accueil', [],Response::HTTP_SEE_OTHER);
    }

    #[Route('/modify/{id}', name: 'app_modify')]
    public function modify(Disc $disc, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(DiscFormType::class, $disc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $uploadedDirectory= $this->getParameter('kernel.project_dir').'/assets/uploads/jaquettes/';
            $uploadedFile = $form->get('picture')->getData();
            if ($uploadedFile){
                $nameFile= str_replace(' ', '', ($disc->getTitle())). '.' . ($uploadedFile->guessExtension());
                $uploadedFile->move($uploadedDirectory, $nameFile);
                $disc->setPicture($nameFile);
            }
            
            $em->persist($disc);
            $em->flush();

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('crud/modify.html.twig', [
            'form' => $form,
            'disc' => $disc,
        ]);
    }

    #[Route('/add', name: 'app_add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $newDisc= new Disc();
        $form = $this->createForm(DiscFormType::class, $newDisc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $uploadedDirectory= $this->getParameter('kernel.project_dir').'/assets/uploads/jaquettes/';
            $uploadedPoster= $form->get('picture')->getData();

            if ($uploadedPoster) {
                $nameFile= str_replace(' ', '', ($newDisc->getTitle())). '.' . ($uploadedPoster->guessExtension());
                $uploadedPoster->move($uploadedDirectory, $nameFile);
                $newDisc->setPicture($nameFile);
            }

            $em->persist($newDisc);
            $em->flush();

            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('crud/add.html.twig', [
            'form' => $form,
            'disc' => $newDisc,
        ]);
    }
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, DiscRepository $repo): Response
    {
        $query = $request->query->get('query');
        $disques = $query ? $repo->findByTitleOrArtist($query) : [];
        $nbDisques = count($disques);

        return $this->render('crud/search.html.twig', [
            'disques' => $disques,
            'query' => $query,
            'nbDisques' => $nbDisques,
        ]);
    }

}
