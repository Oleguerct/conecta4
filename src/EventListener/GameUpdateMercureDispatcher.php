<?php


namespace App\EventListener;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Game::class)]
class GameUpdateMercureDispatcher
{

    /**
     * GameCreatedListener constructor.
     */
    public function __construct(private HubInterface $hub, private SerializerInterface $serializer)
    {
    }

    public function postUpdate(Game $game, PostUpdateEventArgs $updateEventArgs): void
    {
        $update = new Update(
            'https://example.com/game/'.$game->getId(),
            $this->serializer->serialize($game,'json',['groups' => 'game:read'])
        );
        $this->hub->publish($update);
    }
}