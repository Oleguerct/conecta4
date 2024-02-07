<?php


namespace App\EventListener;


use App\Entity\Game;
use App\Service\GameCheckWinnerService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: Game::class )]
class GameSetWinnerListener
{

    /**
     * GameSetWinnerListener constructor.
     */
    public function __construct(private GameCheckWinnerService $winnerService)
    {
    }

    public function preUpdate(Game $game, PreUpdateEventArgs $preUpdateEventArgs): void
    {
        $this->winnerService->checkWinner($game);
    }
}