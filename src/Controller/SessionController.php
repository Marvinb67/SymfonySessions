<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="index_session")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $sessions = $doctrine->getRepository(Session::class)->findBy([], ['dateDebut' => 'ASC']);
        $mtn = new \DateTime();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions,
            'mtn' => $mtn,
        ]);
    }

    /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/update/{id}", name="update_session")
     */
    public function add(ManagerRegistry $doctrine, Session $session = null, Request $requete)
    {
        if (!$session) {
            $session = new Session();
        }

        $em = $doctrine->getManager();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($requete);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();

            $em->persist($session);
            $em->flush();

            return $this->redirectToRoute('index_session');
        }

        return $this->render('session/add.html.twig', [
            'formSession' => $form->createView(),
        ]);
    }

    /**
     * @Route("/session/{id}", name="detail")
     */
    public function detail(Session $session, ManagerRegistry $doctrine): Response
    {
        $stagiaire = $doctrine->getRepository(Stagiaire::class)->getNonInscrits($session->getId());

        dump($stagiaire);

        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'stagiaire' => $stagiaire,
        ]);
    }
}
