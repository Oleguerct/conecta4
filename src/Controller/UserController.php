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
    #[Route('/user/current-game', name: 'app_user_get_game')]
    public function index(Request $request,UserRepository $userRepository): Response
    {
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            return $this->json(['error' => 'Not logged user'], 400);
        }

        if ($game = $user->getCurrentGame()){
            return $this->json($game);
        }

        return $this->json(['error' => 'No game found'], 400);

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

        $currentGame = $user->getCurrentGame();
        $user->setCurrentGame(null);
        $entityManager->flush();

        return $this->json($user);

    }

}
