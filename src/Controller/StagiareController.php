<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiareController extends AbstractController
{
    /**
     * @Route("/stagiaire", name="index_stagiaire")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $stagiaires = $doctrine->getRepository(Stagiaire::class)->findBy([], ['nom' => 'ASC']);

        return $this->render('stagiare/index.html.twig', [
            'stagiaires' => $stagiaires,
        ]);
    }

    /**
     * @Route("/stagiaire/add", name="add_stagiaire")
     * @Route("/stagiaire/update/{id}", name="update_stagiaire")
     */
    public function add(ManagerRegistry $doctrine, Stagiaire $stagiaire = null, Request $requete)
    {
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }

        $em = $doctrine->getManager();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($requete);
        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->getData();

            $em->persist($stagiaire);
            $em->flush();

            return $this->redirectToRoute('index_stagiaire');
        }

        return $this->render('stagiare/add.html.twig', [
            'formStagiaire' => $form->createView(),
        ]);
    }

    /**
     * @Route("/stagiaire/{id}", name="show_stagiaire")
     */
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiare/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }
}
