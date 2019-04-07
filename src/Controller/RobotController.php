<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RobotController extends AbstractController
{

    /**
     * @Route("/next_step", name="next_step", methods={"POST", "GET"})
     * @param Request $request
     * @return Response
     */
    public function getStepForClient(Request $request)
    {
        $data = array();
        $game = $request->query->get('game');
        return new Response(json_encode($game, JSON_UNESCAPED_UNICODE));
    }
}