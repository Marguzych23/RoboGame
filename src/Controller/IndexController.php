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
     * @Route("/index", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
//        TODO work this session
        if (is_null($nickName = $request->get('nickName'))) {
            return $this->redirectToRoute("login");
        }
//        return $this->render('home/index.html.twig');
        return new Response('HOMEPAGE');
    }

}