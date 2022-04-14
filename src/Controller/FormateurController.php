<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormateurController extends AbstractController
{
    /**
     * @Route("/formateur", name="index_formateur")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $formateurs = $doctrine->getRepository(Formateur::class)->findBy([], ['nom' => 'ASC']);

        return $this->render('formateur/index.html.twig', [
            'formateurs' => $formateurs,
        ]);
    }

    /**
     * @Route("/formateur/add", name="add_formateur")
     * @Route("/formateur/update/{id}", name="update_formateur")
     */
    public function add(ManagerRegistry $doctrine, Formateur $formateur = null, Request $requete)
    {
        if (!$formateur) {
            $formateur = new Formateur();
        }

        $em = $doctrine->getManager();
        $form = $this->createForm(FormateurType::class, $formateur);
        $form->handleRequest($requete);
        if ($form->isSubmitted() && $form->isValid()) {
            $formateur = $form->getData();

            $em->persist($formateur);
            $em->flush();

            return $this->redirectToRoute('index_formateur');
        }

        return $this->render('formateur/add.html.twig', [
            'formFormateur' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formateur/delete/{id}", name="delete_formateur")
     */
    public function delete(ManagerRegistry $doctrine, Formateur $formateur)
    {
        $em = $doctrine->getManager();
        $em->remove($formateur);
        $em->flush();

        return $this->redirectToRoute('index_formateur');
    }
}
