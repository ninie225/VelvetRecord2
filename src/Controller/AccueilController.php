<?php

namespace App\Controller;

use App\Entity\Disc;
use App\Repository\DiscRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(DiscRepository $discRepository): Response
    {
        $discs= $discRepository->findAll();
        $nbDiscs = count($discs);

        return $this->render('accueil/index.html.twig', [
            'disques' => $discs,
            'nbDiscs' => $nbDiscs,
        ]);
    }
}
