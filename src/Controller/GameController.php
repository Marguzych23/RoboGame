<?php


namespace App\Controller;


use App\Game\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    /**
     * @Route("/game", name="game", methods={"POST", "GET"})
     * @param Request $request
     * @param GameService $gameService
     * @return mixed
     */
    public function getDeadArea(Request $request, GameService $gameService)
    {
//        TODO work this session
//        if (is_null($nickName = $request->get('nickName'))) {
//            return $this->redirectToRoute("login");
//        }
//        if (is_null($nickName = $request->get('code'))) {
//            return $this->redirectToRoute('home', array('nickName' => $nickName));
//        }

        return new Response(json_encode($gameService->getGame(), JSON_UNESCAPED_UNICODE));

        return $this->render(
            'game/index.html.twig',
            array('')
        );
    }

}