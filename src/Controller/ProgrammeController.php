<?php

namespace App\Controller;

use App\Entity\Planifier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgrammeController extends AbstractController
{
    /**
     * @Route("/programme", name="app_programme")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $programmes = $doctrine->getRepository(Planifier::class)->findAll();

        return $this->render('programme/index.html.twig', [
            'programmes' => $programmes,
        ]);
    }
}
