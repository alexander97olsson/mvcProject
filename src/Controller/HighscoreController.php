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
     * @Route("/create", name="create_score", methods={"POST"})
     */
    public function createScore(Request $request): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action:
        //  createProduct(EntityManagerInterface $entityManager)
        $session = $this->get('session');

        $name = "temp";
        if ($request->request->has("saveScore")) {
            $name = $request->request->get("name");
        }

        $entityManager = $this->getDoctrine()->getManager();

        $highscore = new Highscore();
        $highscore->setName($name);
        $highscore->setScore($session->get('score'));

        $startTime = $session->get('time');
        $today = date("H:i:s");

        $timeElapsed = strtotime($today) - strtotime($startTime);
        $highscore->setTime(strval($timeElapsed));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($highscore);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $allValues = $entityManager->getRepository(Highscore::class)->findAll();
        $allValuesLength = count($allValues);
        $totalScore = 0;
        for ($i = 0; $i < $allValuesLength; $i++) {
            $totalScore = $totalScore + $allValues[$i]->getScore();
        }
        $averageScore = $totalScore / $allValuesLength;

        //updaterar average
        $entityManagerAverage = $this->getDoctrine()->getManager();
        $product = $entityManagerAverage->getRepository(Highscore::class)->find(1);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        $product->setAverage($averageScore);
        $entityManagerAverage->flush();

        return $this->render('message.html.twig', [
            'message' => "Hejsan detta är min start sida, välkommen",
        ]);
    }
    /**
     * @Route("/allscore", name="show_all_Highscore")
     */
    public function showAllHighscore(
        EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        $scoes = array();
        foreach ($highscore as $myObject) {
            $scoes[] = $myObject->score;
        }

        array_multisort($scoes, SORT_DESC, $highscore);

        return $this->render('highscore/showHighscore.html.twig', [
            "highscore" => $highscore,
        ]);
    }
    /**
     * @Route("/showaverage", name="show_average")
     */
    public function showAverage(
        EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        $average = 0;
        foreach ($highscore as $myObject) {
            if ($myObject->getId() == 1) {
                $average = round($myObject->getAverage(), 2);
            }
        }

        return $this->render('highscore/showAverage.html.twig', [
            "average" => $average,
        ]);
    }
    /**
     * @Route("/orderbytime", name="order_by_Time")
     */
    public function orderByTime(
        EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        $scoes = array();
        foreach ($highscore as $myObject) {
            $scoes[] = $myObject->time;
        }

        array_multisort($scoes, SORT_DESC, $highscore);

        return $this->render('highscore/showHighscore.html.twig', [
            "highscore" => $highscore,
        ]);
    }
    /**
     * @Route("/orderbylowest", name="order_by_lowest")
     */
    public function orderByLowest(
        EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        $scoes = array();
        foreach ($highscore as $myObject) {
            $scoes[] = $myObject->score;
        }

        array_multisort($scoes, SORT_ASC, $highscore);

        return $this->render('highscore/showHighscore.html.twig', [
            "highscore" => $highscore,
        ]);
    }
        /**
     * @Route("/orderbyname", name="order_by_name")
     */
    public function orderByName(
        EntityManagerInterface $entityManager
    ): Response {
        $highscore = $entityManager
            ->getRepository(Highscore::class)
            ->findAll();

        $scoes = array();
        foreach ($highscore as $myObject) {
            $scoes[] = $myObject->name;
        }

        array_multisort($scoes, SORT_ASC, $highscore);

        return $this->render('highscore/showHighscore.html.twig', [
            "highscore" => $highscore,
        ]);
    }
}
