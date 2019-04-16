<?php


namespace App\Controller;


use App\Game\Model\Game;
use App\Game\Service\GameService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/home", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
//        TODO work this session
        if (is_null($user = $request->get('user'))) {
            return $this->redirectToRoute("login");
        }
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/about", name="about")
     * @param Request $request
     * @return Response
     */
    public function about(Request $request)
    {
        if (is_null($nickName = $request->get('nickName'))) {
            return $this->redirectToRoute("login");
        }
        return $this->render('home/about.html.twig');
    }

}