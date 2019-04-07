<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function index()
    {
//        return $this->render('auth/index.html.twig');
        return new Response('Auth page');
    }

    public function auth(string $nickName)
    {
        return $this->redirectToRoute('homepage', array('nickName' => $nickName));
    }

}