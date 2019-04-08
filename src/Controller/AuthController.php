<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET"})
     */
    public function index()
    {
        return $this->render('auth/index.html.twig');
    }

    /**
     * @Route("/login", name="auth", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function auth(Request $request)
    {
        $nickName = $request->get('nickName', null);
        $nickName = 'Marguzych';
        if (is_null($nickName)) {
            return new JsonResponse("Введите имя пользователя");
        }
        return $this->redirectToRoute('homepage', array('nickName' => $request->get('nickName')));
    }

}