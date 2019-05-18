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

    protected $marguzych = 'defaultMarguzych';

    /**
     * @Route("/game", name="game", methods={"POST", "GET"})
     * @param Request $request
     * @param GameService $gameService
     * @return mixed
     */
    public function getDeadArea(Request $request, GameService $gameService)
    {
        $nickName = $request->get('nickName', null);
        if ($gameService->gameIsStarted() == false) {
            $nickName = $this->marguzych;
            if (is_null($nickName)) {
                return $this->redirectToRoute("login");
            }
            $script = $request->get('script', null);
            $script = 'code';
            if (is_null($script)) {
                return $this->redirectToRoute('homepage', array('nickName' => $nickName));
            }

            $robotIsCreated = $gameService->setRobot($nickName, $script);

            if ($robotIsCreated === false) {
                return new JsonResponse(array(
                    'result' => false
                ));
            }
        }

        return new JsonResponse(
            $gameService->getGameDTO($gameService->getGame()),
            200,
            array(),
            true
        );

    }

    /**
     * @Route("/game/get_next_step", name="get_next_step_game", methods={"GET", "POST"})
     * @param Request $request
     * @param GameService $gameService
     * @return JsonResponse
     * @throws \Exception
     */
    public function getNextStep(Request $request, GameService $gameService)
    {
        $nickName = $request->get('nickName', $this->marguzych);
        if (is_null($nickName)) {
            return new JsonResponse(array(
                'result' => false
            ));
        }
        return new JsonResponse(
            $gameService->getGameDTO($gameService->getNextStepGame()),
            200,
            array(),
            true
        );
    }

    /**
     * @Route("/game/reset", name="reset_game", methods={"GET", "POST"})
     * @param Request $request
     * @param GameService $gameService
     * @return JsonResponse
     * @throws \Exception
     */
    public function resetGame(Request $request, GameService $gameService)
    {
        $nickName = $request->get('nickName', $this->marguzych);
        if (is_null($nickName)) {
            return new JsonResponse(array(
                'result' => false
            ));
        }
        return new JsonResponse(
            json_encode(array(
                'result' => $gameService->resetGame()
            )),
            200,
            array(),
            true
        );
    }
}