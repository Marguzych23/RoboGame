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
////        TODO work with session
//        $nickName = $request->get('nickName', null);
//        $nickName = 'Marguzych';
//        if (is_null($nickName)) {
//            return $this->redirectToRoute("login");
//        }
//        $script = $request->get('script', null);
//        $script = 'code';
//        if (is_null($script)) {
//            return $this->redirectToRoute('homepage', array('nickName' => $nickName));
//        }
//
//        $robotIsCreated = $gameService->setRobot($nickName, $script);
//
//        if ($robotIsCreated === false) {
//            return new JsonResponse(array(
//                'result' => false
//            ));
//        }

        return $this->render(
            'game/index.html.twig',
            array(
//                'nickName' => $nickName,
                'game' => json_encode($gameService->getGame(), JSON_UNESCAPED_UNICODE),
//                'game' => $gameService->getGame(),
            )
        );
    }

    /**
     * @Route("/game/get_next_step", name="get_next_step_game", methods={"POST"})
     * @param Request $request
     * @param GameService $gameService
     * @return JsonResponse
     * @throws \Exception
     */
    public function getNextStep(Request $request, GameService $gameService)
    {
        $game = $request->get('game', null);
        if (is_null($game)) {
            return new JsonResponse(array(
                'result' => false
            ));
        }
        return new JsonResponse(json_encode($gameService->getNextStepGame(), JSON_UNESCAPED_UNICODE));
    }
}