<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Repository\UserRepository;
use App\Service\GameMoverService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{

    #[Route('/game/create/{gameName}', name: 'app_game_create')]
    public function create(
        string $gameName,
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ): Response
    {

        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            throw new \Exception('User must be logged in to create a game');
        }

        if($user->getGame()){
            $user->getGame()->removePlayer($user);
        }

        //$user->setCurrentGame(null);
        $entityManager->flush();

        $game = new Game();
        $game->setTitle($gameName);
        $game->addPlayer($user);
        $entityManager->persist($game);
        $entityManager->flush();

        return $this->json($game);

    }

    #[Route('/game/get_available', name: 'app_game_get_available')]
    public function get_available(
        GameRepository $gameRepository
    ): Response
    {

        $games = $gameRepository->findAvailableToPlay();
        return $this->json($games, 200,[],['groups' => 'game:read']);

    }

    #[Route('/game/join/{gameId}', name: 'app_join_game')]
    public function join(
        int $gameId,
        Request $request,
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
        UserRepository $userRepository
    ): Response
    {
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            throw new \Exception('User must be logged in to join a game');
        }

        if($user->getGame()){
            $user->getGame()->removePlayer($user);
        }

        $game = $gameRepository->find($gameId);
        $game->addPlayer($user);
        $entityManager->flush();

        return $this->json($game);

    }

    #[Route('/game/move/{columnIndex}', name: 'app_move_game')]
    public function move(
        int $columnIndex,
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        GameMoverService $gameMovementService
    ){
        $session = $request->getSession();

        if($userID = $session->get('user_id')){
            $user = $userRepository->find($userID);
        }else{
            throw new \Exception('User must be logged in to play');
        }


        $game = $user->getGame();

        if($game->getWinner()) return new Response(null,403);

        $gameMovementService->setGame($game);
        $gameMovementService->move( $user, $columnIndex);

        $entityManager->flush($game);

        return new Response(null,200);

    }

    #[Route('/game/get/{id}', name: 'app_get_game')]
    public function get_game(int $id, GameRepository $gameRepository)
    {
        $game = $gameRepository->find($id);
        return $this->json($game, 200, [],['groups' => 'game:read']);
    }
}
