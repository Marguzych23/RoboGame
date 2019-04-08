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
     * @Route("/create_robot", name="create_robot", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function getStepForClient(Request $request)
    {
//        TODO
        $script = $request->get("script", null);
        if (is_null($script)) {
            return new JsonResponse("Error");
        }
        return $this->redirectToRoute("homepage");
    }


    /**
     * @Route("/create_robot", name="create_robot_page", methods={"GET"})
     */
    public function createRobot()
    {
        return $this->render("robot/create.html.twig");
    }
}