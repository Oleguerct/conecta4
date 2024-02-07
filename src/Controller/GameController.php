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
use Symfony\Component\Serializer\SerializerInterface;

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

        $user->setCurrentGame(null);
        $entityManager->flush();

        $game = new Game();
        $game->setTitle($gameName);
        $game->addPlayer($user);
        $game->setPlayer1ID($user->getId());
        $game->setTurn(1);
        $entityManager->persist($game);
        $entityManager->flush();

        return $this->json($game);

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

        $game = $gameRepository->find($gameId);
        $game->addPlayer($user);
        $game->setPlayer2ID($user->getId());
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


        $game = $user->getCurrentGame();

        if($game->getWinner()) return new Response(null,403);

        $gameMovementService->setGame($game);
        $gameMovementService->move( $user, $columnIndex);

        $entityManager->flush($game);

        return new Response(null,200);

    }
}
