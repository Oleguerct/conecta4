<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


    // get user by session
    #[Route('/user/get_by_session', name: 'app_user')]
    public function get_by_session(Request $request, UserRepository $userRepository): Response
    {
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            return $this->json(null, 204);
        }

        return $this->json($user);
    }

    #[Route('/user/current-game', name: 'app_user_get_game')]
    public function index(Request $request,UserRepository $userRepository): Response
    {
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            return $this->json(['error' => 'Not logged user'], 400);
        }

        if ($game = $user->getGame()){
            return $this->json($game, $game == null ? 204 : 200);
        }

        return new Response(null,204);

    }

    #[Route('/user/left-game', name: 'app_user_left_game')]
    public function leftGame(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            throw new \Exception('User must be logged in to left game');
        }

        $currentGame = $user->getGame();
        $user->setCurrentGame(null);
        $currentGame->removePlayer($user);
        $entityManager->flush();

        return $this->json($user);

    }

}
