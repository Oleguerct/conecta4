<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class MainController extends AbstractController
{

    #[Route('/', name: 'app_main')]
    public function index(Request $request, UserRepository $userRepository): Response
    {
        $username = '';
        $session = $request->getSession();
        if($session->get('user_id')){
            $user = $userRepository->find($session->get('user_id'));
            $username = $user->getUsername();
        }

        $userObject = isset($user) ? ['username' => $user->getUsername(), 'userId' => $user->getId()] : '';

        return $this->render('main/main.html.twig',[
            'userObj' => $userObject
        ]);
    }

    #[Route('/publish', name: 'app_publish')]
    public function publish(HubInterface $hub): Response
    {
        $update = new Update(
            'https://example.com/books/1',
            json_encode(['status' => 'published'])
        );

        $hub->publish($update);

        return new Response('published!');
    }

    #[Route('/js', name: 'app_js')]
    public function js(HubInterface $hub): Response
    {


        return $this->render('main/js.html.twig');
    }
}
