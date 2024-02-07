<?php


namespace App\EventListener;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Game::class)]
class GameCreateMercureDispatcher
{


    /**
     * GameCreateMercureDispatcher constructor.
     * @param HubInterface $hub
     * @param SerializerInterface $serializer
     */
    public function __construct(private HubInterface $hub, private SerializerInterface $serializer)
    {
    }

    public function postPersist(Game $game, PostPersistEventArgs $persistEventArgs): void
    {
        $update = new Update(
            'https://example.com/games',
            $this->serializer->serialize($game,'json')
        );
        $this->hub->publish($update);
    }
}