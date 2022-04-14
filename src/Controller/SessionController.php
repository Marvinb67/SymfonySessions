<?php

namespace App\Controller;

use App\Entity\ModuleFormation;
use App\Entity\Planifier;
use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
            'sessionId' => $session->getId(),
        ]);
    }

    /**
     * @Route("/session/addStagiaire/{idStagiaire}/{idSession}", name="addStagiaire")
     * @ParamConverter("stagiaire", options={"mapping" = {"idStagiaire": "id"}})
     * @ParamConverter("session", options={"mapping" = {"idSession": "id"}})
     */
    public function inscription(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire): Response
    {
        $em = $doctrine->getManager();
        $session->addStagiaire($stagiaire);
        $em->flush();

        return $this->redirectToRoute('detail', [
            'id' => $session->getId(),
        ]);
    }

    /**
     * @Route("/session/removeStagiaire/{idStagiaire}/{idSession}", name="removeStagiaire")
     * @ParamConverter("stagiaire", options={"mapping" = {"idStagiaire": "id"}})
     * @ParamConverter("session", options={"mapping" = {"idSession": "id"}})
     */
    public function removeStagiaire(ManagerRegistry $doctrine, Session $session, Stagiaire $stagiaire)
    {
        $em = $doctrine->getManager();
        $session->removeStagiaire($stagiaire);
        $em->flush();

        return $this->redirectToRoute('detail', [
            'id' => $session->getId(),
        ]);
    }

    /**
     * @Route("/session/programmeModule/{idSession}/{idModule}", name="programmeModule")
     * @ParamConverter("session", options={"mapping" = {"idSession": "id"}})
     * @ParamConverter("moduleForma", options={"mapping" = {"idModule": "id"}})
     */
    public function programmeModule(ManagerRegistry $doctrine, Session $session, ModuleFormation $moduleForma, Request $request)
    {
        $em = $doctrine->getManager();

        $newModu = new Planifier();

        $jours = $request->get('jours');

        $newModu->setSessions($session);
        $newModu->setModulesFormation($moduleForma);
        $newModu->setDuree($jours);

        $em->persist($newModu);
        $em->flush();

        return $this->redirectToRoute('detail', [
            'id' => $session->getId(),
        ]);
    }

    /**
     * @Route("/session/removeModule/{idSession}/{idPlanifier}", name="removeModule")
     * @ParamConverter("session", options={"mapping" = {"idSession": "id"}})
     * @ParamConverter("planifier", options={"mapping" = {"idPlanifier": "id"}})
     */
    public function removeModule(ManagerRegistry $doctrine, Planifier $planifier, Session $session): Response
    {
        $em = $doctrine->getManager();

        $session->removePlanifier($planifier);

        $em->remove($planifier);

        $em->persist($session);

        $em->flush();

        return $this->redirectToRoute('detail', [
           'id' => $session->getId(),
       ]);
    }

    /**
     * @Route("/session/{id}", name="detail")
     */
    public function detail(Session $session, ManagerRegistry $doctrine, ModuleFormation $moduleF): Response
    {
        $stagiaireNI = $doctrine->getRepository(Stagiaire::class)->getNonInscrits($session->getId());
        $modulesF = $doctrine->getRepository(ModuleFormation::class)->getNonPlanifier($session->getId());

        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'stagiaireNI' => $stagiaireNI,
            'modulesF' => $modulesF,
        ]);
    }
}
