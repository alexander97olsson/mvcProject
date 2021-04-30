<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Highscore;

class HighscoreController extends AbstractController
{
    /**
     * @Route("/highscore", name="highscore")
     */
    public function index(): Response
    {
        return $this->render('highscore/index.html.twig', [
            'controller_name' => 'HighscoreController',
        ]);
    }

        /**
     * @Route("/highscore/create", name="create_score", methods={"POST"})
     */
    public function createScore(Request $request): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action:
        //  createProduct(EntityManagerInterface $entityManager)
        $session = $this->get('session');

        if ($request->request->has("saveScore")) {
            $name = $request->request->get("name");
        }

        $entityManager = $this->getDoctrine()->getManager();
    
        $highscore = new Highscore();
        $highscore->setName($name);
        $highscore->setScore($session->get('score'));
    
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($highscore);
    
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
    
        return $this->render('highscore/index.html.twig', [
            'controller_name' => 'HighscoreController',
        ]);
    }
    /**
     * @Route("/highscore/all", name="show_all_Highscore")
     */
    public function showAllHighscore(
            EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        return $this->render('highscore/showHighscore.html.twig', [
            "highscore" => $highscore,
        ]);
    }
}
