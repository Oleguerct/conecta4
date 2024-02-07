<?php


namespace App\EventListener;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: User::class)]
class UserCreatedSessionHandler
{


    /**
     * UserCreatedSessionHandler constructor.
     */
    public function __construct(private RequestStack $requestStack,)
    {

    }

    public function postPersist(User $user, PostPersistEventArgs $persistEventArgs): void
    {
        // TODO: Securitzar això
        $session = $this->requestStack->getSession();
        $session->set('user_id', $user->getId());
    }
}