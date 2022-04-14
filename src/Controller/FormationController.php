<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $formations = $doctrine->getRepository(Formation::class)->findBy([], ['intitule' => 'ASC']);

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/formation/add", name="add_formation")
     * @Route("/formation/update/{id}", name="update_formation")
     */
    public function add(ManagerRegistry $doctrine, Formation $formation = null, Request $requete)
    {
        if (!$formation) {
            $formation = new Formation();
        }

        $em = $doctrine->getManager();

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($requete);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();

            $em->persist($formation);
            $em->flush();

            return $this->redirectToRoute('formation');
        }

        return $this->render('formation/add.html.twig', [
            'formFormation' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formation/delete/{id}", name="delete_formation")
     */
    public function delete(ManagerRegistry $doctrine, Formation $forma)
    {
        $em = $doctrine->getManager();

        $em->remove($forma);

        $em->flush();

        return $this->redirect('formation');
    }

    /**
     * @Route("/formation/show/{id}", name="show_formation")
     */
    public function show(Formation $formation)
    {
        $mtn = new \DateTime();

        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
            'mtn' => $mtn,
        ]);
    }
}
