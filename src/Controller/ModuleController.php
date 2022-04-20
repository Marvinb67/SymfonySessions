<?php

namespace App\Controller;

use App\Entity\ModuleFormation;
use App\Form\ModuleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/module", name="module")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $modules = $doctrine->getRepository(ModuleFormation::class)->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("/module/add", name="add_module")
     * @Route("/module/update/{id}", name="update_module")
     */
    public function add(ManagerRegistry $doctrine, ModuleFormation $mf = null, Request $requete)
    {
        if (!$mf) {
            $mf = new ModuleFormation();
        }

        $em = $doctrine->getManager();

        $form = $this->createForm(ModuleType::class, $mf);

        $form->handleRequest($requete);
        if ($form->isSubmitted() && $form->isValid()) {
            $module = $form->getData();

            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('module');
        }

        return $this->render('module/add.html.twig', [
            'formModule' => $form->createView(),
        ]);
    }
}
