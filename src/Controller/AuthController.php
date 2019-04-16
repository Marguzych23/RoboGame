<?php


namespace App\Controller;


use App\Form\UserType;
use App\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function login(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('homepage', array('user' => $user->jsonSerialize()));
        }

        return $this->render(
            'auth/index.html.twig',
            array('form' => $form->createView())
        );
    }
//
//    /**
//     * @Route("/login", name="auth", methods={"POST"})
//     * @param Request $request
//     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function auth(Request $request)
//    {
//        $nickName = $request->get('nickName', null);
//        $nickName = 'Marguzych';
//        if (is_null($nickName)) {
//            return new JsonResponse("Введите имя пользователя");
//        }
//        return $this->redirectToRoute('homepage', array('nickName' => $request->get('nickName')));
//    }

}